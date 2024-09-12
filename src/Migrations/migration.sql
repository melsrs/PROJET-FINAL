
CREATE TABLE Article
(
  Id_Article      INT          NOT NULL AUTO_INCREMENT,
  titre           VARCHAR(255) NOT NULL,
  texte           TEXT         NOT NULL,
  date            DATETIME     NOT NULL,
  image           VARCHAR(255) NULL    ,
  Id_Categorie    INT          NOT NULL,
  Id_Utilisateur_ INT          NOT NULL,
  PRIMARY KEY (Id_Article)
);

ALTER TABLE Article
  ADD CONSTRAINT UQ_Id_Article UNIQUE (Id_Article);

CREATE TABLE Categorie
(
  Id_Categorie INT         NOT NULL AUTO_INCREMENT,
  type         VARCHAR(50) NOT NULL,
  PRIMARY KEY (Id_Categorie)
);

ALTER TABLE Categorie
  ADD CONSTRAINT UQ_Id_Categorie UNIQUE (Id_Categorie);

CREATE TABLE Commenter
(
  Id_Article       INT      NOT NULL,
  Id_Utilisateur   INT      NOT NULL,
  message          TEXT     NOT NULL,
  date_commentaire DATETIME NOT NULL,
  valide           BOOLEAN  NOT NULL,
  PRIMARY KEY (Id_Article, Id_Utilisateur)
);

CREATE TABLE Humain
(
  Id_Humain    INT         NOT NULL AUTO_INCREMENT,
  prenom       VARCHAR(50) NULL    ,
  nom          VARCHAR(50) NOT NULL,
  age          VARCHAR(50) NULL    ,
  anniversaire VARCHAR(50) NOT NULL,
  taille       VARCHAR(50) NOT NULL,
  affiliation  VARCHAR(50) NOT NULL,
  Id_Article   INT         NOT NULL,
  PRIMARY KEY (Id_Humain)
);

ALTER TABLE Humain
  ADD CONSTRAINT UQ_Id_Humain UNIQUE (Id_Humain);

CREATE TABLE Likes
(
  Id_Article     INT NOT NULL,
  Id_Utilisateur INT NOT NULL,
  PRIMARY KEY (Id_Article, Id_Utilisateur)
);

CREATE TABLE Role
(
  Id_Role INT         NOT NULL AUTO_INCREMENT,
  type    VARCHAR(50) NOT NULL,
  PRIMARY KEY (Id_Role)
);

ALTER TABLE Role
  ADD CONSTRAINT UQ_Id_Role UNIQUE (Id_Role);

CREATE TABLE Titan
(
  Id_Titan         INT         NOT NULL AUTO_INCREMENT,
  nom              VARCHAR(50) NOT NULL,
  taille           VARCHAR(50) NOT NULL,
  pouvoir          VARCHAR(50) NOT NULL,
  allegeance       VARCHAR(50) NOT NULL,
  detenteur_actuel VARCHAR(50) NOT NULL,
  ancien_detenteur VARCHAR(50) NULL    ,
  Id_Article       INT         NOT NULL,
  PRIMARY KEY (Id_Titan)
);

ALTER TABLE Titan
  ADD CONSTRAINT UQ_Id_Titan UNIQUE (Id_Titan);

CREATE TABLE Utilisateur
(
  Id_Utilisateur INT          NOT NULL AUTO_INCREMENT,
  prenom         VARCHAR(50)  NOT NULL,
  nom            VARCHAR(50)  NOT NULL,
  mail           VARCHAR(255) NOT NULL,
  mdp            VARCHAR(255) NOT NULL,
  Id_Role        INT          NOT NULL,
  PRIMARY KEY (Id_Utilisateur)
);

ALTER TABLE Utilisateur
  ADD CONSTRAINT UQ_Id_Utilisateur UNIQUE (Id_Utilisateur);

ALTER TABLE Utilisateur
  ADD CONSTRAINT FK_Role_TO_Utilisateur
    FOREIGN KEY (Id_Role)
    REFERENCES Role (Id_Role);

ALTER TABLE Article
  ADD CONSTRAINT FK_Categorie_TO_Article
    FOREIGN KEY (Id_Categorie)
    REFERENCES Categorie (Id_Categorie);

ALTER TABLE Article
  ADD CONSTRAINT FK_Utilisateur_TO_Article
    FOREIGN KEY (Id_Utilisateur_)
    REFERENCES Utilisateur (Id_Utilisateur);

ALTER TABLE Titan
  ADD CONSTRAINT FK_Article_TO_Titan
    FOREIGN KEY (Id_Article)
    REFERENCES Article (Id_Article);

ALTER TABLE Humain
  ADD CONSTRAINT FK_Article_TO_Humain
    FOREIGN KEY (Id_Article)
    REFERENCES Article (Id_Article);

ALTER TABLE Likes
  ADD CONSTRAINT FK_Article_TO_Likes
    FOREIGN KEY (Id_Article)
    REFERENCES Article (Id_Article);

ALTER TABLE Likes
  ADD CONSTRAINT FK_Utilisateur_TO_Likes
    FOREIGN KEY (Id_Utilisateur)
    REFERENCES Utilisateur (Id_Utilisateur);

ALTER TABLE Commenter
  ADD CONSTRAINT FK_Article_TO_Commenter
    FOREIGN KEY (Id_Article)
    REFERENCES Article (Id_Article);

ALTER TABLE Commenter
  ADD CONSTRAINT FK_Utilisateur_TO_Commenter
    FOREIGN KEY (Id_Utilisateur)
    REFERENCES Utilisateur (Id_Utilisateur);
