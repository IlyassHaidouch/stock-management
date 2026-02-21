drop database if exists stock_management;
create database if not exists stock_management;
use stock_management;

create table marchandise(
	reference varchar(50) primary key,
	designation varchar(50),
	categorie varchar(50),
	stock_initial int(30),
	prix_unitaire float(50),
	total float(50)

);

create table entrees(
	numero int(4) auto_increment primary key,
	_date date,
	reference varchar(50),
	designation varchar(50),
	categorie varchar(50),
	cout_achat float(10),
	quantite int(10),
	total float(10)
);

create table sorties(
	numero int(4) auto_increment primary key,
	_date date,
	reference varchar(50),
	designation varchar(50),
	categorie varchar(50),
	prix_vente float(10),
	quantite int(10),
	total float(10)
);

create table utilisateur(
	iduser int(4) auto_increment primary key,
	login varchar(50),
	email varchar(255),
	role varchar(50),
	etat int(1),
	pwd varchar(255)
);

alter table entrees add constraint foreign key(reference) references marchandise(reference);
alter table sorties add constraint foreign key(reference) references marchandise(reference);


INSERT INTO utilisateur(login,email,role,etat,pwd) VALUES 
    ('admin','admin@gmail.com','ADMIN',1,md5('123')),
    ('user1','user1@gmail.com','VISITEUR',0,md5('123')),
    ('user2','user2@gmail.com','VISITEUR',1,md5('123'));


INSERT INTO marchandise(reference,designation,categorie,stock_initial,prix_unitaire,total) VALUES
    ('Pb01','R-18','Pare-brise',3,800.00,stock_initial*prix_unitaire),
    ('Pb02','R-12','Pare-brise',3,700.00,stock_initial*prix_unitaire),
    ('Pb03','R-16','Pare-brise',2,800.00,stock_initial*prix_unitaire),
    ('Pb04','R-19','Pare-brise',1,800.00,stock_initial*prix_unitaire),
    ('Pb05','R-20','Pare-brise',3,750.00,stock_initial*prix_unitaire),
    ('Pb06','R-21','Porte-av',2,650.00,stock_initial*prix_unitaire),
    ('Pb08','R-25','Pare-brise',3,800.00,stock_initial*prix_unitaire),
    ('Pb09','R-Kadjar','Pare-brise',3,800.00,stock_initial*prix_unitaire),
    ('Pb10','R-Megane','Pare-brise',3,800.00,stock_initial*prix_unitaire);


INSERT INTO entrees(_date, reference, designation, categorie, cout_achat, quantite, total) VALUES('2023/04/25', 'Pb01', 'R-18', 'Pare-brise', 800.00, 3, stock_initial*prix_unitaire);