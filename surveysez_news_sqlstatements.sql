/*
surveysez_news_sqlstatements.sql

*/

#categories list view
SELECT CategoryID, CategoryName, Description FROM wn16_news_categories;

#subcategories list view
SELECT f.FeedID,f.FeedName, f.Description FROM wn16_feeds f 
INNER JOIN wn16_news_categories nc 
ON nc.CategoryID = f.CategoryID 
WHERE nc.CategoryID = 1;

#pull the url from the db feeds given the feed ID
SELECT FeedName,FeedUrl,Description FROM wn16_feeds 
WHERE FeedID = 1;