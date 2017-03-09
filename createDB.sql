Create Database news_db;

Create Table Categories (
CategoryID int unsigned not null auto_increment primary key,
CategoryName varchar(120),
Description text
);

Create Table Feeds (
FeedID int unsigned not null auto_increment primary key,
FeedName varchar(120),
CategoryID int Default 0,
RSS text
);

Insert Into Categories (CategoryName, Description)
Values ("Music", "");

Insert Into Categories (CategoryName, Description)
Values ("Sports", "");

Insert Into Categories (CategoryName, Description)
Values ("Weather", "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("Blues", 1, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("Jazz", 1, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("Classical", 1, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("Football", 2, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("Baseball", 2, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("Basketball", 2, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("Puget Sound", 3, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("California", 3, "");

Insert Into Feeds (FeedName, CategoryID, RSS)
Values ("East Coast", 3, "");