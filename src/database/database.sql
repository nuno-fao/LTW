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
	"gender"	TEXT NOT NULL CHECK("gender" = 'f' OR "gender" = 'm'),
	FOREIGN KEY("profilePic") REFERENCES "Photos"("photoId") on update cascade on delete cascade,
	FOREIGN KEY("species") REFERENCES "Species"("specieId") on update cascade on delete cascade,
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade,
	FOREIGN KEY("state") REFERENCES "PetState"("petStetId") on update cascade on delete cascade,
	FOREIGN KEY("color") REFERENCES "Colors"("color") on update cascade on delete cascade,
	PRIMARY KEY("petId")
);
CREATE TABLE IF NOT EXISTS "Proposals" (
	"proposalId"	INTEGER NOT NULL,
	"user"	INTEGER NOT NULL,
	"pet"	INTEGER NOT NULL,
	"state"	TEXT,
	"text"	INTEGER,
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade,
	PRIMARY KEY("proposalId" AUTOINCREMENT),
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Questions" (
	"questionId"	INTEGER NOT NULL,
	"questionTxt"	TEXT NOT NULL,
	"pet"	INTEGER NOT NULL,
	"date"	TEXT,
	"user"	INTEGER,
	PRIMARY KEY("questionId" AUTOINCREMENT),
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade,
	FOREIGN KEY("user") REFERENCES "Users"("userId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Queries" (
	"queryId"	INTEGER NOT NULL,
	"specie"	INTEGER,
	"sizeTopLimit"	REAL,
	"sizeBottomLimit"	REAL,
	"color"	TEXT,
	"location"	INTEGER,
	"state"	INTEGER,
	"gender"	TEXT,
	PRIMARY KEY("queryId" AUTOINCREMENT),
	FOREIGN KEY("specie") REFERENCES "Species"("specieId") on update cascade on delete cascade,
	FOREIGN KEY("state") REFERENCES "PetState"("petStetId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Photos" (
	"photoId"	INTEGER NOT NULL,
	"path"	TEXT NOT NULL UNIQUE,
	"pet"	INTEGER NOT NULL,
	PRIMARY KEY("photoId" AUTOINCREMENT),
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "PetState" (
	"petStetId"	INTEGER NOT NULL,
	"state"	TEXT NOT NULL,
	PRIMARY KEY("petStetId" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "Favourites" (
	"user"	TEXT NOT NULL,
	"pet"	INTEGER NOT NULL,
	PRIMARY KEY("user","pet"),
	FOREIGN KEY("user") REFERENCES "Users"("userName") on update cascade on delete cascade,
	FOREIGN KEY("pet") REFERENCES "Pets"("petId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Answers" (
	"answerId"	INTEGER NOT NULL,
	"answerTxt"	TEXT NOT NULL,
	"question"	INTEGER NOT NULL,
	"date"	TEXT NOT NULL,
	"author"	INTEGER NOT NULL,
	PRIMARY KEY("answerId" AUTOINCREMENT),
	FOREIGN KEY("question") REFERENCES "Questions"("questionId") on update cascade on delete cascade,
	FOREIGN KEY("author") REFERENCES "Users"("userId") on update cascade on delete cascade
);
CREATE TABLE IF NOT EXISTS "Users" (
	"userId"	INTEGER NOT NULL,
	"Name"	TEXT NOT NULL,
	"EmailAddress"	TEXT NOT NULL UNIQUE COLLATE NOCASE,
	"userName"	TEXT NOT NULL UNIQUE,
	"password"	TEXT NOT NULL CHECK(length("password") >= 8),
	"picturePath"	TEXT DEFAULT '../img/defaultpic.png',
	PRIMARY KEY("userId" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "Colors" (
	"color"	TEXT NOT NULL UNIQUE,
	PRIMARY KEY("color")
);
CREATE TABLE IF NOT EXISTS "Species" (
	"specieId"	INTEGER NOT NULL,
	"specie"	TEXT NOT NULL UNIQUE,
	PRIMARY KEY("specieId" AUTOINCREMENT)
);
INSERT INTO "Pets" VALUES (1,'Woof',1,55,'Brown','Porto',3,1,1,'f');
INSERT INTO "Pets" VALUES (2,'Prince',2,20,'White','Porto',1,1,3,'m');
INSERT INTO "Pets" VALUES (3,'',5,102,'White','Faro',2,2,5,'f');
INSERT INTO "Pets" VALUES (4,'Ronaldo',3,5,'Yellow','Paços De Ferreira',1,3,6,'f');
INSERT INTO "Pets" VALUES (5,'Jessica',4,10,'White','Belém',1,3,8,'f');
INSERT INTO "Pets" VALUES (6,'Spirit',10,200,'Brown','Setúbal',1,4,11,'m');
INSERT INTO "Pets" VALUES (7,'Laggy',8,80,'Blue','Beja',1,4,12,'m');
INSERT INTO "Pets" VALUES (8,'Palhaço',7,11,'Orange','Aveiro',1,4,13,'f');
INSERT INTO "Pets" VALUES (9,'Cocas',9,2,'Orange','Viseu',1,5,16,'m');
INSERT INTO "Pets" VALUES (10,'Moisés',1,60,'White','Santarém',1,5,18,'m');
INSERT INTO "Pets" VALUES (11,'Maria',2,25,'White','Famalicão',2,5,20,'f');
INSERT INTO "Pets" VALUES (12,'Tony',2,20,'Black','Vila Das Aves',1,5,21,'m');
INSERT INTO "Proposals" VALUES (1,4,1,'1','Sou de aveiro e tenho todas as condições para adotar a Woof se me permitir :)');
INSERT INTO "Proposals" VALUES (2,5,1,'2','Sou de Nárnia e tenho mais centauro ansioso por fazer novas amizades e a Woof seria ideal');
INSERT INTO "Proposals" VALUES (3,4,11,'1','Adoraria de adotar a Maria para juntá-la à minha coleção.');
INSERT INTO "Proposals" VALUES (4,4,3,'1','Que criatura fantástica? Tenho as condições ideias para ela');
INSERT INTO "Proposals" VALUES (5,1,11,'0','Eu voluntario-me para adotar este gato.');
INSERT INTO "Questions" VALUES (1,'Já teve alguma ninhada?',1,'1608223733',4);
INSERT INTO "Questions" VALUES (2,'Sabe separar as águas do Nilo?',10,'1608224320',1);
INSERT INTO "Questions" VALUES (3,'Quantas riscas brancas tem?',8,'1608224424',1);
INSERT INTO "Questions" VALUES (4,'Que lindo, desculpe eu sou daltónico. De que cor são os olhos?',11,'1608224495',4);
INSERT INTO "Questions" VALUES (5,'Desculpa lá mas isso é bicho de se pôr neste site?',9,'1608224607',5);
INSERT INTO "Questions" VALUES (6,'Porque se chama Jessica?',5,'1608224754',5);
INSERT INTO "Questions" VALUES (7,'Está no ubuntu?',2,'1608224793',3);
INSERT INTO "Questions" VALUES (8,'Quantos meses tem?',12,'1608225480',1);
INSERT INTO "Questions" VALUES (9,'Porque se chama Ronaldo?',4,'1608225518',5);
INSERT INTO "Questions" VALUES (10,'Eu sou de Madrid? Estaria disponivel a trazê-lo cá para eu o adotar?',7,'1608225596',2);
INSERT INTO "Photos" VALUES (1,'../img/pet_pic15fdb81524ca25',1);
INSERT INTO "Photos" VALUES (2,'../img/pet_pic15fdb815254258',1);
INSERT INTO "Photos" VALUES (3,'../img/pet_pic25fdb83c791f6f',2);
INSERT INTO "Photos" VALUES (4,'../img/pet_pic25fdb83c7990b4',2);
INSERT INTO "Photos" VALUES (5,'../img/pet_pic35fdb8498a3ec5',3);
INSERT INTO "Photos" VALUES (6,'../img/pet_pic45fdb85ad5da74',4);
INSERT INTO "Photos" VALUES (7,'../img/pet_pic45fdb85ad64d7b',4);
INSERT INTO "Photos" VALUES (8,'../img/pet_pic55fdb8673d0cc2',5);
INSERT INTO "Photos" VALUES (9,'../img/pet_pic55fdb8673d7468',5);
INSERT INTO "Photos" VALUES (10,'../img/pet_pic55fdb8673dbf1b',5);
INSERT INTO "Photos" VALUES (11,'../img/pet_pic65fdb86f786da2',6);
INSERT INTO "Photos" VALUES (12,'../img/pet_pic75fdb87807cef1',7);
INSERT INTO "Photos" VALUES (13,'../img/pet_pic85fdb87e2e3c23',8);
INSERT INTO "Photos" VALUES (14,'../img/pet_pic85fdb87e2eb358',8);
INSERT INTO "Photos" VALUES (15,'../img/pet_pic85fdb87e2f08f3',8);
INSERT INTO "Photos" VALUES (16,'../img/pet_pic95fdb88a60f3b9',9);
INSERT INTO "Photos" VALUES (17,'../img/pet_pic95fdb88a615149',9);
INSERT INTO "Photos" VALUES (18,'../img/pet_pic105fdb8a1455757',10);
INSERT INTO "Photos" VALUES (19,'../img/pet_pic105fdb8a145b8bb',10);
INSERT INTO "Photos" VALUES (20,'../img/pet_pic115fdb8ac30066c',11);
INSERT INTO "Photos" VALUES (21,'../img/pet_pic125fdb8b0d569b5',12);
INSERT INTO "Photos" VALUES (22,'../img/pet_pic125fdb8b0d6be45',12);
INSERT INTO "PetState" VALUES (1,'For Adoption');
INSERT INTO "PetState" VALUES (2,'Proposal Accepted');
INSERT INTO "PetState" VALUES (3,'Adopted');
INSERT INTO "Favourites" VALUES ('default_user',12);
INSERT INTO "Favourites" VALUES ('default_user',4);
INSERT INTO "Favourites" VALUES ('soraiafq',9);
INSERT INTO "Answers" VALUES (1,'Não, está pronta para a ação :)',1,'1608223784',1);
INSERT INTO "Answers" VALUES (2,'Deseja saber mais alguma coisa?',1,'1608223950',1);
INSERT INTO "Answers" VALUES (3,'Era só isso mesmo.',1,'1608223984',4);
INSERT INTO "Answers" VALUES (4,'3 obviamente, burro.',3,'1608224464',4);
INSERT INTO "Answers" VALUES (5,'Ups...',5,'1608224631',5);
INSERT INTO "Answers" VALUES (6,'Não, este sabe morder as partes baixas.',2,'1608224665',5);
INSERT INTO "Answers" VALUES (7,'Também não sei, o bichinho não é meu.',4,'1608224702',5);
INSERT INTO "Answers" VALUES (8,'Eu confirmo que não apesar de nunca a ter visto.',1,'1608224738',5);
INSERT INTO "Answers" VALUES (9,'Inculto, não merece que lhe responda.',6,'1608224784',3);
INSERT INTO "Answers" VALUES (10,'What?',7,'1608224808',2);
INSERT INTO "Answers" VALUES (11,'Deixa lá ele pensa que é engraçadinho.',7,'1608224838',4);
INSERT INTO "Answers" VALUES (12,'Não, este usa MSDOS :)',7,'1608224881',1);
INSERT INTO "Answers" VALUES (13,'Por causa da crista.',9,'1608225543',2);
INSERT INTO "Answers" VALUES (14,'Lamento mas não.',10,'1608225617',4);
INSERT INTO "Users" VALUES (1,'Default John Doe User','defaultuser@example.com','default_user','$2y$10$4CeSdbdr.YyljTtocOCQEuQAWTBLYwG5zk6O8m3zkGPoQjLHePgU.','../img/defaultpic.png');
INSERT INTO "Users" VALUES (2,'Soraia Fel Qualidade','soraiafq@exampleemail.com','soraiafq','$2y$10$gKC9cCz1C7XmKyq09MjHVe/VrftONjpEMgQ4uo/J9WSSS1xAY4exW','../img/defaultpic.png');
INSERT INTO "Users" VALUES (3,'Juiz Raio Falcao','raiofalcao@example-mail.com','raiofalcao','$2y$10$r6nQLltG6pvU2FZ2lMQfh.YGjndLYTaiUAlN.FZwPs2qbRf/WYpSe','../img/defaultpic.png');
INSERT INTO "Users" VALUES (4,'Pereira Pulmões De Ferro','grandespulmoes@example-mail.com','pereirapulmoes','$2y$10$0YfDQMrS4WhTNFDc1aq/fOIsP3uJQiN4.WHJgqTQS5I/BOYjrqs.G','../img/defaultpic.png');
INSERT INTO "Users" VALUES (5,'Joao Do Pao De Trigo','comeapapa@example-mail.com','joaopao','$2y$10$2SooWkoGPieWwWF8N4OuzuzMBS82TXnBZyiGsTMvS7QiVH7J0FjLq','../img/defaultpic.png');
INSERT INTO "Colors" VALUES ('White');
INSERT INTO "Colors" VALUES ('Brown');
INSERT INTO "Colors" VALUES ('Blue');
INSERT INTO "Colors" VALUES ('Red');
INSERT INTO "Colors" VALUES ('Green');
INSERT INTO "Colors" VALUES ('Black');
INSERT INTO "Colors" VALUES ('Grey');
INSERT INTO "Colors" VALUES ('Pink');
INSERT INTO "Colors" VALUES ('Yellow');
INSERT INTO "Colors" VALUES ('Orange');
INSERT INTO "Colors" VALUES ('Purple');
INSERT INTO "Species" VALUES (1,'Dog');
INSERT INTO "Species" VALUES (2,'Cat');
INSERT INTO "Species" VALUES (3,'Bird');
INSERT INTO "Species" VALUES (4,'Rabbit');
INSERT INTO "Species" VALUES (5,'Snake');
INSERT INTO "Species" VALUES (6,'Hamster');
INSERT INTO "Species" VALUES (7,'Fish');
INSERT INTO "Species" VALUES (8,'Reptile');
INSERT INTO "Species" VALUES (9,'Amphibian');
INSERT INTO "Species" VALUES (10,'Equine');
COMMIT;
