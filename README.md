# SQL Enhancement

## Technologies Used
- **Database setup & data seeding:** PHP 8 (Laravel 12) 
- **Database:** MySQL 8
- **Virtualization:** Vagrant

## Installation & Setup
  
### Clone the Repository
```sh
git clone https://github.com/luqmannasir55/job-portal.git
cd job-portal
```

### Set Up Vagrant
```sh
vagrant up
vagrant ssh
```

### Inside Vagrant:

```sh
cd /var/www/html
php artisan migrate
```

### Seeding Datas into the DB:

- Run this command one by one and in order (each seeder will insert 100000 rows in the respective tables)
- One keyword data (キャビンアテンダント) will be inserted in affiliate, basic_abilities, job_categories, jobs, jobs_types, personalities, practical_skills table to test this query

```sh
php artisan db:seed --class=AffiliateSeeder
php artisan db:seed --class=JobCategorySeeder
php artisan db:seed --class=JobTypeSeeder
php artisan db:seed --class=PersonalitySeeder
php artisan db:seed --class=PracticalSkillSeeder
php artisan db:seed --class=BasicAbilitySeeder
php artisan db:seed --class=JobSeeder
php artisan db:seed --class=JobBasicAbilitySeeder
php artisan db:seed --class=JobCareerPathSeeder
php artisan db:seed --class=JobPersonalitySeeder
php artisan db:seed --class=JobPracticalSkillSeeder
php artisan db:seed --class=JobRecQualificationSeeder
php artisan db:seed --class=JobReqQualificationSeeder
php artisan db:seed --class=JobToolSeeder
```


## Enhancement to improve the performance of SQL Query

1. Apply fulltext indexing (these columns has already been altered in the respective tables during php artisan migrate)
   ```sql
   ALTER TABLE jobs ADD FULLTEXT(name, description, detail, business_skill, knowledge, location, activity, salary_statistic_group, salary_range_remarks, restriction, remarks);
   ALTER TABLE job_categories ADD FULLTEXT(name);
   ALTER TABLE job_types ADD FULLTEXT(name);
   ALTER TABLE personalities ADD FULLTEXT(name);
   ALTER TABLE practical_skills ADD FULLTEXT(name);
   ALTER TABLE basic_abilities ADD FULLTEXT(name);
   ALTER TABLE affiliates ADD FULLTEXT(name);
   ```

2. Enhanced SQL Query

```sql

-- PRE-FILTER QUERY
-- APPLY PRE-FILTER WITH MATCHES IN EACH TABLES BEFORE JOINING WITH THE MAIN QUERY
WITH MatchedJobs AS (
  SELECT id, 3 AS source_flag, 'jobs' AS source_table -- source_table TO INDICATE THE ORIGIN TABLE OF MATCHED JOB, source_flag IS USED IN THE MAIN QUERY FOR ORDERING THE JOBS THAT HAVE MORE MATCHES WILL APPEAR FIRST,
  FROM jobs -- PRIORITISE MATCHES FROM JOBS TABLE, FOLLOWED BY CATEGORIES & TYPES, THEN OTHERS
  WHERE MATCH(name, description, detail, business_skill, knowledge, location, activity, salary_statistic_group, salary_range_remarks, restriction, remarks) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE) -- USE MATCH AGAINST FOR BETTER PERFORMANCE COMPARED TO THE USE OF LIKE AND WILDCARD
  AND publish_status = 1 AND deleted IS NULL
), 
MatchedJobCategories AS (
  SELECT Jobs.id AS job_id, 2 AS source_flag, 'job_categories' AS source_table
  FROM jobs Jobs
  INNER JOIN job_categories JobCategories ON JobCategories.id = Jobs.job_category_id
  WHERE MATCH (JobCategories.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND Jobs.deleted IS NULL AND JobCategories.deleted IS NULL
),
MatchedJobTypes AS (
  SELECT Jobs.id AS job_id, 1 AS source_flag, 'job_types' AS source_table
  FROM jobs Jobs
  INNER JOIN job_types JobTypes ON JobTypes.id = Jobs.job_type_id
  WHERE MATCH (JobTypes.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND Jobs.deleted IS NULL AND JobTypes.deleted IS NULL
),
MatchedPersonalities AS (
  SELECT JobsPersonalities.job_id, 1 AS source_flag, 'jobs_personalities' AS source_table
  FROM jobs_personalities JobsPersonalities
  INNER JOIN personalities Personalities ON Personalities.id = JobsPersonalities.personality_id
  WHERE MATCH (Personalities.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND JobsPersonalities.deleted IS NULL AND Personalities.deleted IS NULL
),
MatchedPracticalSkills AS (
  SELECT JobsPracticalSkills.job_id, 1 AS source_flag, 'jobs_practical_skills' AS source_table 
  FROM jobs_practical_skills JobsPracticalSkills
  INNER JOIN practical_skills PracticalSkills ON PracticalSkills.id = JobsPracticalSkills.practical_skill_id
  WHERE MATCH (PracticalSkills.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND JobsPracticalSkills.deleted IS NULL AND PracticalSkills.deleted IS NULL
),
MatchedBasicAbilities AS (
  SELECT JobsBasicAbilities.job_id, 1 AS source_flag, 'jobs_basic_abilities' AS source_table 
  FROM jobs_basic_abilities JobsBasicAbilities
  INNER JOIN basic_abilities BasicAbilities ON BasicAbilities.id = JobsBasicAbilities.basic_ability_id
  WHERE MATCH (BasicAbilities.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND JobsBasicAbilities.deleted IS NULL AND BasicAbilities.deleted IS NULL
),
MatchedTools AS (
  SELECT JobsTools.job_id, 1 AS source_flag, 'jobs_tools' AS source_table
  FROM jobs_tools JobsTools
  INNER JOIN affiliates Tools ON Tools.id = JobsTools.affiliate_id AND Tools.type = 1
  WHERE MATCH (Tools.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND JobsTools.deleted IS NULL AND Tools.deleted IS NULL
),
MatchedCareerPaths AS (
  SELECT JobsCareerPaths.job_id, 1 AS source_flag, 'jobs_career_paths' AS source_table 
  FROM jobs_career_paths JobsCareerPaths
  INNER JOIN affiliates CareerPaths ON CareerPaths.id = JobsCareerPaths.affiliate_id AND CareerPaths.type = 3
  WHERE MATCH (CareerPaths.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND JobsCareerPaths.deleted IS NULL AND CareerPaths.deleted IS NULL
),
MatchedRecQualifications AS (
  SELECT JobsRecQualifications.job_id, 1 AS source_flag, 'jobs_rec_qualifications' AS source_table
  FROM jobs_rec_qualifications JobsRecQualifications
  INNER JOIN affiliates RecQualifications ON RecQualifications.id = JobsRecQualifications.affiliate_id AND RecQualifications.type = 2
  WHERE MATCH (RecQualifications.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND JobsRecQualifications.deleted IS NULL AND RecQualifications.deleted IS NULL
),
MatchedReqQualifications AS (
  SELECT JobsReqQualifications.job_id, 1 AS source_flag, 'jobs_req_qualifications' AS source_table 
  FROM jobs_req_qualifications JobsReqQualifications
  INNER JOIN affiliates ReqQualifications ON ReqQualifications.id = JobsReqQualifications.affiliate_id AND ReqQualifications.type = 2
  WHERE MATCH (ReqQualifications.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
  AND JobsReqQualifications.deleted IS NULL AND ReqQualifications.deleted IS NULL
),
AllMatchedJobs AS ( -- CONSOLIDATE ALL MATCHED JOBS TO A SINGLE TABLE (AllMatchedJobs)
  SELECT job_id, SUM(source_flag) AS match_source, JSON_ARRAYAGG(source_table) AS source_table FROM ( -- SUM(source_flag) TO CALCULATE HOW MANY MATCHES OCCURRED, source_table TO CONSOLIDATE TABLE ORIGIN
    SELECT job_id, source_flag, source_table FROM MatchedPersonalities
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedPracticalSkills
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedBasicAbilities
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedTools
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedCareerPaths
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedRecQualifications
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedReqQualifications
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedJobTypes
    UNION ALL
    SELECT job_id, source_flag, source_table FROM MatchedJobCategories
    UNION ALL
    SELECT id AS job_id, source_flag, source_table FROM MatchedJobs
  ) AS sources
  GROUP BY job_id
)

-- MAIN QUERY
SELECT 
Jobs.id AS `Jobs__id`, 
Jobs.name AS `Jobs__name`,
Jobs.media_id AS `Jobs__media_id`,
Jobs.job_category_id AS `Jobs__job_category_id`,
Jobs.job_type_id AS `Jobs__job_type_id`,
Jobs.description AS `Jobs__description`,
Jobs.detail AS `Jobs__detail`,
Jobs.business_skill AS `Jobs__business_skill`,
Jobs.knowledge AS `Jobs__knowledge`,
Jobs.location AS `Jobs__location`,
Jobs.activity AS `Jobs__activity`,
Jobs.academic_degree_doctor AS `Jobs__academic_degree_doctor`,
Jobs.academic_degree_master AS `Jobs__academic_degree_master`,
Jobs.academic_degree_professional AS `Jobs__academic_degree_professional`,
Jobs.academic_degree_bachelor AS `Jobs__academic_degree_bachelor`,
Jobs.salary_statistic_group AS `Jobs__salary_statistic_group`,
Jobs.salary_range_first_year AS `Jobs__salary_range_first_year`,
Jobs.salary_range_average AS `Jobs__salary_range_average`,
Jobs.salary_range_remarks AS `Jobs__salary_range_remarks`,
Jobs.restriction AS `Jobs__restriction`,
Jobs.estimated_total_workers AS `Jobs__estimated_total_workers`,
Jobs.remarks AS `Jobs__remarks`,
Jobs.url AS `Jobs__url`,
Jobs.seo_description AS `Jobs__seo_description`,
Jobs.seo_keywords AS `Jobs__seo_keywords`,
Jobs.sort_order AS `Jobs__sort_order`,
Jobs.publish_status AS `Jobs__publish_status`,
Jobs.version AS `Jobs__version`,
Jobs.created_by AS `Jobs__created_by`,
Jobs.created AS `Jobs__created`,
Jobs.modified AS `Jobs__modified`,
Jobs.deleted AS `Jobs__deleted`,
JobCategories.id AS `JobCategories__id`,
JobCategories.name AS `JobCategories__name`,
JobTypes.id AS `JobTypes__id`,
JobTypes.name AS `JobTypes__name`,
AllMatchedJobs.match_source,
AllMatchedJobs.source_table

FROM jobs Jobs
INNER JOIN job_categories JobCategories ON JobCategories.id = Jobs.job_category_id AND JobCategories.deleted IS NULL
INNER JOIN job_types JobTypes ON JobTypes.id = Jobs.job_type_id AND JobTypes.deleted IS NULL
INNER JOIN AllMatchedJobs ON Jobs.id = AllMatchedJobs.job_id -- JOIN WITH PRE-FILTERED TABLE

WHERE Jobs.publish_status = 1 AND Jobs.deleted IS NULL

ORDER BY match_source DESC, Jobs.sort_order DESC -- SORT BY MORE MATCHES TO APPEAR FIRST,THEN CUSTOM SORTING FROM DATABASE
LIMIT 50 OFFSET 0;

```

## Result
The comparison of execution for both queries are shown below :

![querytime](https://github.com/user-attachments/assets/bb99efc4-3a14-4f13-adaf-a6c764ffcb85)

