# Tábor Smrčná

* summer camp situated next to the Sázava river
* this source code could be generalized (with the fine modifications) and used for your camp too, I will be glad 
* not so sophisticated solution due to time pressure and the fact that I am not PHP developer (and hate this language :))
* maybe I will refactor that one day, maybe not

http://taborsmrcna.cz/

## What you need to run it

* MySQL ~5.6
* PHP >= 5.4
* Apache2 or Nginx
* composer
* [script](https://github.com/bouchja1/tabor.smrcna/blob/master/camp_db.sql) to create and fill DB with initial values
* a knowledge how to calculate a password which is stored to DB: base64_encode(YOUR_PASSWORD + YOUR_SALT_FROM_DB)

