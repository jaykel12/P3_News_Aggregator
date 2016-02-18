/*
surveysez_news_dbtables.sql

this file contains sql statments that add the required db tables for the news agregation feature that is to be added to the SurveySez site

entity: Categories-specifies the available categoreis for the news feature.

-> newsCategoryID: PK Auto increament, Not null, int unsigned
-> categoryName: varchar, not null
-> description: text
-> dateAdded: date

entity: feed- specifies feeds information

-> newsFeedID: PK Auto increament, Not null, int unsigned 
-> newsCategoryID: FK Not null, int unsigned
-> feedName: varchar, Not null
-> feedUrl: varchar, not null
-> description: text
-> dateAdded: date

*/

SET foreign_key_checks = 0; #turn off constraints temporarily

#since constraints cause problems, drop tables first, working backward
DROP TABLE IF EXISTS wn16_feeds;
DROP TABLE IF EXISTS wn16_news_categories;

#categories table
CREATE TABLE wn16_news_categories(
CategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
CategoryName VARCHAR(100) NOT NULL,
Description TEXT DEFAULT '',
DateAdded DATETIME DEFAULT NOW(),
PRIMARY KEY (CategoryID)
)ENGINE=INNODB;

#inserting the intial categories
INSERT INTO wn16_news_categories VALUES (NULL,"Sports","From Google news",NOW());
INSERT INTO wn16_news_categories VALUES (NULL,"Technology","From Google news",NOW());
INSERT INTO wn16_news_categories VALUES (NULL,"Politics","From Google news",NOW());

#feeds table
CREATE TABLE wn16_feeds(
FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
CategoryID INT UNSIGNED NOT NULL,
FeedName VARCHAR(100) NOT NULL,
FeedUrl VARCHAR(255) NOT NULL,
Description TEXT DEFAULT '',
DateAdded DATETIME DEFAULT NOW(),
PRIMARY KEY (FeedID),
FOREIGN KEY (CategoryID) REFERENCES wn16_news_categories(CategoryID) ON DELETE CASCADE
)ENGINE=INNODB;

#inserts subcategories
INSERT INTO wn16_feeds VALUES (NULL,1,"Football","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Football&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,1,"Soccer","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Soccer&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,1,"Tennis","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Tennis&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,2,"Medical","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Medical+Technology&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,2,"Apple","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Apple&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,2,"Samsung","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Samsung&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,3,"U.S.","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Politics+U.S.&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,3,"Europe","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Politics+Europe&output=rss","This is optional",NOW());
INSERT INTO wn16_feeds VALUES (NULL,3,"Trump","https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Politics+Trump&output=rss","This is optional",NOW());

SET foreign_key_checks = 1; #turn foreign key check back on