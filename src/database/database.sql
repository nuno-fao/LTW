BEGIN TRANSACTION;
PRAGMA foreign_keys=on;
CREATE TABLE IF NOT EXISTS "Species" (
	"specieId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"specie"	TEXT NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS "Colors" (
	"color"	TEXT NOT NULL UNIQUE,
	PRIMARY KEY("color")
);
CREATE TABLE IF NOT EXISTS "Users" (
	"userId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"Name"	TEXT NOT NULL,
	"EmailAddress"	TEXT NOT NULL UNIQUE COLLATE NOCASE,
	"userName"	TEXT NOT NULL UNIQUE,
	"password"	TEXT NOT NULL CHECK(length("password")>=8),
	"picturePath"	TEXT DEFAULT '../img/defaultpic.png'
);
CREATE TABLE IF NOT EXISTS "Answers" (
	"answerId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"answerTxt"	TEXT NOT NULL,
	"question"	INTEGER NOT NULL,
	"date"	TEXT NOT NULL,
	"author"	INTEGER NOT NULL,
	FOREIGN KEY("author") REFERENCES "Users"("userId") on update cascade on delete cascade,
	FOREIGN KEY("question") REFERENCES "Questions"("questionId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Favourites" (
	"user"	TEXT NOT NULL,
	"pet"	INTEGER NOT NULL,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade,
	FOREIGN KEY("user") REFERENCES "Users"("userName") on update cascade on delete cascade,
	PRIMARY KEY("user","pet")
);
CREATE TABLE IF NOT EXISTS "PetState" (
	"petStetId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"state"	TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS "Photos" (
	"photoId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"path"	TEXT NOT NULL UNIQUE,
	"pet"	INTEGER NOT NULL,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
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
	FOREIGN KEY("state") REFERENCES "PetState"("petStetId") on update cascade on delete cascade,
	FOREIGN KEY("specie") REFERENCES "Species"("specieId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Questions" (
	"questionId"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"questionTxt"	TEXT NOT NULL,
	"pet"	INTEGER NOT NULL,
	"date"	TEXT,
	"user"	INTEGER,
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Pets" (
	"petId"	INTEGER NOT NULL,
	"name"	TEXT,
	"species"	INTEGER NOT NULL,
	"size"	REAL NOT NULL,
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
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
);
INSERT INTO "Species" ("specieId","specie") VALUES (1,'Dog'),
 (2,'Cat');
INSERT INTO "Colors" ("color") VALUES ('black'),
 ('white'),
 ('brown'),
 ('grey');
INSERT INTO "Users" ("userId","Name","EmailAddress","userName","password","picturePath") VALUES (11,'Luís Miguel Afonso Pinto','lmiguelapinto@gmail.com','rocas777','$2y$10$TnMGSP8pKUjC0avouEbz0e8pGIczoS1B1HNT0umBk.6JA4ueTV0jW','../img/defaultpic.png'),
 (12,'Nuno Filipe Amaral Oliveira','oliveiranunopt@gmail.com','nunation','$2y$10$WvEpOLrlwj9rluXdfAOUzOAGG9phnFmj7S.csYdp/tBd3jElpVOCW','../img/defaultpic.png');
INSERT INTO "Answers" ("answerId","answerTxt","question","date","author") VALUES (1,'deves achar que tens piada',3,'1589059244',11),
 (2,'yah lmao',3,'1589059244',12),
 (9,'batatas',1,'1607651150',12),
 (11,'yes it is',14,'1607678896',11),
 (12,'he is lovely',14,'1607678942',11);
INSERT INTO "Favourites" ("user","pet") VALUES ('nunation',2),
 ('nunation',1),
 ('rocas777',1);
INSERT INTO "PetState" ("petStetId","state") VALUES (1,'For Adoption'),
 (2,'Proposal Accepted'),
 (3,'Addopted');
INSERT INTO "Photos" ("photoId","path","pet") VALUES (23,'../img/pet_main_pic1',1),
 (25,'../img/dog.jpg',2);
INSERT INTO "Questions" ("questionId","questionTxt","pet","date","user") VALUES (1,'Ele sabe usar ubuntu?',1,'1508247532',12),
 (3,'Claro que sabe, ela nao e um viking!!!!!!!
vou-te a cara, ahahahahh',1,'1607435463',12),
 (14,'Is that a real photo?',2,'1607655865',12),
 (22,'oaa',2,'1607890825',12),
 (23,'a',2,'1607890829',12);
INSERT INTO "Pets" ("petId","name","species","size","color","location","state","user","profilePic","gender") VALUES (1,'Mimi',2,30.0,'brown','Aveiro',1,11,23,'f'),
 (2,'Batata',1,50.0,'black','Narnia',1,12,25,'m');
INSERT INTO "Proposals" ("proposalId","user","pet","state","text") VALUES (1,12,1,'2','I would love to adopt Mimi'),
 (2,11,2,'2','I would love to adopt Batata, I have two other dogs and i have great conditions for addopting'),
 (9,11,2,'1','eu tenho fome e ele chama-se batata...');
COMMIT;
