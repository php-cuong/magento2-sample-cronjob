Hi Everybody !

Today, I introduce everybody a best practice. How to set up and run cron job in Magento 2 using custom module.

As far as I know, Cron is a Linux utility which schedules a command or script on your server to run automatically at a specified time and date.

In Magento 2, It requires multiple cron jobs to initiate tasks such as reindexing, generating sitemaps, applying price rules, and other critical activities at a specified time or date interval.

Today, I will show you how to set up and run cron job in Magento 2 using custom module.

This procedure consists of three steps:

#Step 1: I need to create a file {Magento root}/app/code/PHPCuong/SampleCronJob/etc/crontab.xml, see the code in the path etc/crontab.xml.

Explain this code, let’s check the params in detail:
- Node “group” specifies the group of the cron tasks, which our cronjob should belong to. Magento 2 has only two groups “default” and “index” from the box. It is called in the file cron_groups.xml
- Node “job” has 3 the params:
 + name – the unique identifier of the cronjob. Will appear as a “job_code” in the “cron_schedule” database table of magento installation;
 + instance – class that should be instantiated;
 + method – method of the class instance that should be called.
- Node “schedule” is the time the cron will run. In this example, it run in each minute.
You can understand:
* * * * * *
| | | | | |
| | | | | +-- Year              (range: 1900-3000)
| | | | +---- Day of the Week   (range: 1-7, 1 standing for Monday)
| | | +------ Month of the Year (range: 1-12)
| | +-------- Day of the Month  (range: 1-31)
| +---------- Hour              (range: 0-23)
+------------ Minute            (range: 0-59)

#Step 2: I need to create a file {Magento root}/app/code/PHPCuong/SampleCronJob/Cron/Example.php, see the code in the path Cron/Example.php.

#Step 3: Run cron job and see results

- Clean all cache: php bin/magento cache:clean
- Enable module: php bin/magento module:enable PHPCuong_SampleCronJob
- Upgrade database: php bin/magento setup:upgrade
- Generate static content: php bin/magento setup:static-content:deploy
- Run cron job: php bin/magento cron:run

#See video step by step creating and running cron job here:
https://www.youtube.com/watch?v=wGZmPIp7beo
