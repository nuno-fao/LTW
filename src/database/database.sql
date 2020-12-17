BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "Pets" (
	"petId"	INTEGER NOT NULL,
	"name"	TEXT,
	"species"	INTEGER NOT NULL,
	"size"	INTEGER NOT NULL,
	"color"	TEXT NOT NULL COLLATE NOCASE,
	"location"	INTEGER NOT NULL,
	"state"	INTEGER NOT NULL,
	"user"	INTEGER NOT NULL,
	"profilePic"	INTEGER NOT NULL UNIQUE,
	"gender"	TEXT NOT NULL CHECK(gender='f' or gender='m'),
	FOREIGN KEY("state") REFERENCES "PetState"("petStetId") on update cascade on delete cascade,
	FOREIGN KEY("color") REFERENCES "Colors"("color") on update cascade on delete cascade,
	FOREIGN KEY("species") REFERENCES "Species"("specieId") on update cascade on delete cascade,
	PRIMARY KEY("petId"),
	FOREIGN KEY("profilePic") REFERENCES "Photos"("photoId") on update cascade on delete cascade,
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Proposals" (
	"proposalId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"user"	INTEGER NOT NULL,
	"pet"	INTEGER NOT NULL,
	"state"	TEXT,
	"text"	INTEGER,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade,
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Questions" (
	"questionId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"questionTxt"	TEXT NOT NULL,
	"pet"	INTEGER NOT NULL,
	"date"	TEXT,
	"user"	INTEGER,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade,
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Queries" (
	"queryId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"specie"	INTEGER,
	"sizeTopLimit"	REAL,
	"sizeBottomLimit"	REAL,
	"color"	TEXT,
	"location"	INTEGER,
	"state"	INTEGER,
	"gender"	TEXT,
	FOREIGN KEY("specie") REFERENCES "Species"("specieId") on update cascade on delete cascade,
	FOREIGN KEY("state") REFERENCES "PetState"("petStetId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Photos" (
	"photoId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"path"	TEXT NOT NULL UNIQUE,
	"pet"	INTEGER NOT NULL,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "PetState" (
	"petStetId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"state"	TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS "Favourites" (
	"user"	TEXT NOT NULL,
	"pet"	INTEGER NOT NULL,
	PRIMARY KEY("user","pet"),
	FOREIGN KEY("user") REFERENCES "Users"("userName") on update cascade on delete cascade,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Answers" (
	"answerId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"answerTxt"	TEXT NOT NULL,
	"question"	INTEGER NOT NULL,
	"date"	TEXT NOT NULL,
	"author"	INTEGER NOT NULL,
	FOREIGN KEY("question") REFERENCES "Questions"("questionId") on update cascade on delete cascade,
	FOREIGN KEY("author") REFERENCES "Users"("userId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Users" (
	"userId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"Name"	TEXT NOT NULL,
	"EmailAddress"	TEXT NOT NULL UNIQUE COLLATE NOCASE,
	"userName"	TEXT NOT NULL UNIQUE,
	"password"	TEXT NOT NULL CHECK(length("password")>=8),
	"picturePath"	TEXT DEFAULT '../img/defaultpic.png'
);
CREATE TABLE IF NOT EXISTS "Colors" (
	"color"	TEXT NOT NULL UNIQUE,
	PRIMARY KEY("color")
);
CREATE TABLE IF NOT EXISTS "Species" (
	"specieId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"specie"	TEXT NOT NULL UNIQUE
);
COMMIT;
