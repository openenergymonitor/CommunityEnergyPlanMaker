   
<?php
  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

 db_query(
        "CREATE TABLE users
        (
        id int NOT NULL AUTO_INCREMENT, 
        PRIMARY KEY(id),
        username varchar(30),
        password varchar(64),
        salt varchar(3),
        apikey_write varchar(64),
        apikey_read varchar(64),
        admin int
      )"); 

  db_query(
  "CREATE TABLE input
  (
    id int NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(id),
    userid int,
    name text,
    processList text,
    time DATETIME,
    value float,
    status int
  )");

  db_query(
  "CREATE TABLE feeds
  (
    id int NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(id),
    name text,
    tag text,
    time DATETIME,
    value FLOAT,
    status int,
    today FLOAT,
    yesterday FLOAT,
    week FLOAT,
    month FLOAT,
    year FLOAT
  )");

  db_query(
  "CREATE TABLE feed_relation
  (
    userid int,
    feedid int
  )");

  db_query("CREATE TABLE  `energyaudit` (
`userid` INT NOT NULL ,
`key` TEXT NOT NULL ,
`value` TEXT NOT NULL
)");

  db_query(
  "CREATE TABLE dashboard
  (
    userid int,
    content text
  )");

  //---------------------------

  // Password are both: DTCV20356CT
  db_query("INSERT INTO users (username,password,salt) VALUES ('DECC 2008','7b8531f8fd5092664472567cd44e2b79d4df94509853793026eb367d937c82fd','9fc')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('1',  'elec_tot',  '3800')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('1',  'oil_L',  '2850')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('1',  'oil_eff',  '56')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('1',  'car1_miles',  '13000')");

  db_query("INSERT INTO users (username,password,salt) VALUES ('ZCB 2030','7b8531f8fd5092664472567cd44e2b79d4df94509853793026eb367d937c82fd','9fc')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('2',  'elec_tot',  '3000')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('2',  'green_elec',  'yes')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('2',  'wood_m3',  '3.5')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('2',  'wood_eff',  '100')");
  db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('2',  'ecar_miles',  '26000')");

?>
