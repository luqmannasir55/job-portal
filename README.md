# SQL Enhancement

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
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

*Each table in the database job-portal is randomlly seeded using Laravel's DatabaseSeeder

## Enhancement to improve the performance of SQL Query

1. Apply fulltext indexing (running this alter query might take some time)
   ```sql
   ALTER TABLE jobs ADD FULLTEXT(name, description, detail, business_skill, knowledge, location, activity);
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
-- APPLY PRE-FILTER WITH OTHER TABLES BEFORE JOINING WITH THE MAIN QUERY
WITH MatchedJobs AS (
  SELECT id, 1 AS source_flag, 'jobs' AS source_table -- source_table TO INDICATE THE ORIGIN TABLE OF MATCHED JOB, source_flag IS USED IN THE MAIN QUERY FOR ORDERING THE JOBS THAT HAVE MORE MATCHES WILL APPEAR FIRST,  
  FROM jobs
  WHERE MATCH(name, description, detail, business_skill, knowledge, location, activity)
        AGAINST ('キャビンアテンダント' IN BOOLEAN MODE) -- USE MATCH AGAINST FOR BETTER PERFORMANCE COMPARED TO THE USE OF LIKE AND WILDCARD
), 
MatchedPersonalities AS (
  SELECT JobsPersonalities.job_id, 1 AS source_flag, 'jobs_personalities' AS source_table
  FROM jobs_personalities JobsPersonalities
  INNER JOIN personalities Personalities 
      ON Personalities.id = JobsPersonalities.personality_id
  WHERE MATCH (Personalities.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
),
MatchedPracticalSkills AS (
  SELECT JobsPracticalSkills.job_id, 1 AS source_flag, 'jobs_practical_skills' AS source_table 
  FROM jobs_practical_skills JobsPracticalSkills
  INNER JOIN practical_skills PracticalSkills 
      ON PracticalSkills.id = JobsPracticalSkills.practical_skill_id
  WHERE MATCH (PracticalSkills.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
),
MatchedBasicAbilities AS (
  SELECT JobsBasicAbilities.job_id, 1 AS source_flag, 'jobs_basic_abilities' AS source_table 
  FROM jobs_basic_abilities JobsBasicAbilities
  INNER JOIN basic_abilities BasicAbilities 
      ON BasicAbilities.id = JobsBasicAbilities.basic_ability_id
  WHERE MATCH (BasicAbilities.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
),
MatchedTools AS (
  SELECT JobsTools.job_id, 1 AS source_flag, 'jobs_tools' AS source_table
  FROM jobs_tools JobsTools
  INNER JOIN affiliates Tools 
      ON Tools.id = JobsTools.affiliate_id AND Tools.type = 1
  WHERE MATCH (Tools.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
),
MatchedCareerPaths AS (
  SELECT JobsCareerPaths.job_id, 1 AS source_flag, 'jobs_career_paths' AS source_table 
  FROM jobs_career_paths JobsCareerPaths
  INNER JOIN affiliates CareerPaths 
      ON CareerPaths.id = JobsCareerPaths.affiliate_id AND CareerPaths.type = 3
  WHERE MATCH (CareerPaths.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
),
MatchedRecQualifications AS (
  SELECT JobsRecQualifications.job_id, 1 AS source_flag, 'jobs_rec_qualifications' AS source_table
  FROM jobs_rec_qualifications JobsRecQualifications
  INNER JOIN affiliates RecQualifications 
      ON RecQualifications.id = JobsRecQualifications.affiliate_id AND RecQualifications.type = 2
  WHERE MATCH (RecQualifications.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
),
MatchedReqQualifications AS (
  SELECT JobsReqQualifications.job_id, 1 AS source_flag, 'jobs_req_qualifications' AS source_table 
  FROM jobs_req_qualifications JobsReqQualifications
  INNER JOIN affiliates ReqQualifications 
      ON ReqQualifications.id = JobsReqQualifications.affiliate_id AND ReqQualifications.type = 2
  WHERE MATCH (ReqQualifications.name) AGAINST ('キャビンアテンダント' IN BOOLEAN MODE)
),
AllMatchedJobs AS ( -- CONSOLIDATE ALL MATCHED JOBS TO A SINGLE TABLE (AllMatchedJobs)
  SELECT job_id, SUM(source_flag) AS match_source, JSON_ARRAYAGG(source_table) AS source_table FROM ( -- SUM(source_flag) TO CALCULATE HOW MANY MATCHES OCCURRED, source_table TO CONSOLIDATE TABLE ORIGIN 
    SELECT job_id, source_flag, source_table FROM MatchedPersonalities
    UNION ALL
    SELECT job_id, source_flag,source_table FROM MatchedPracticalSkills
    UNION ALL
    SELECT job_id, source_flag,source_table FROM MatchedBasicAbilities
    UNION ALL
    SELECT job_id, source_flag,source_table FROM MatchedTools
    UNION ALL
    SELECT job_id, source_flag,source_table FROM MatchedCareerPaths
    UNION ALL
    SELECT job_id, source_flag,source_table FROM MatchedRecQualifications
    UNION ALL
    SELECT job_id, source_flag,source_table FROM MatchedReqQualifications
    UNION ALL
    SELECT id AS job_id, source_flag,source_table FROM MatchedJobs
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
INNER JOIN job_categories JobCategories  ON JobCategories.id = Jobs.job_category_id AND JobCategories.deleted IS NULL
INNER JOIN job_types JobTypes ON JobTypes.id = Jobs.job_type_id AND JobTypes.deleted IS NULL
INNER JOIN AllMatchedJobs ON Jobs.id = AllMatchedJobs.job_id -- JOIN WITH PRE-FILTERED TABLE

WHERE Jobs.publish_status = 1 AND Jobs.deleted IS NULL

ORDER BY match_source DESC, Jobs.sort_order DESC -- SORT BY MORE MATCHES TO APPEAR FIRST,THEN CUSTOM SORTING FROM DATABASE
LIMIT 50 OFFSET 0;
```
