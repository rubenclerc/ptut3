create table Challenge (
	idChallenge int primary key not null AUTO_INCREMENT,
	nomChallenge varchar(255),
	dateDebut datetime,
	dateFin datetime,
	nbPartcipants int,
	difficulte int,
	compteAdmin int,
	compteJoueur int
);

create table Compte(
	idCompte int primary key not null AUTO_INCREMENT,
	estAdmin boolean,
	username varchar(255),
	passw varchar(255)
);

create table Tentative(
	idTentative int primary key not null AUTO_INCREMENT
);


create table Essayer(
	codeEssaye int,
	tentative int not null,
	joueurAttaquant int not null,
	joueurAttaque int not null,
	primary key(tentative,joueurAttaquant,joueurAttaque)
);



create table Participer(
	codeJoueur int,
	nbPoints int,
	challenge int not null,
	joueur int not null,
	primary key (challenge, joueur)
);

alter table Challenge add constraint fk_cAdmin foreign key (compteAdmin) references Compte(idCompte);

alter table Challenge add constraint fk_cJoueur foreign key (compteJoueur) references Compte(idCompte);

alter table Essayer add constraint fk_tentative foreign key (tentative) references Tentative(idTentative);

alter table Essayer add constraint fk_joueurAttaquant foreign key (joueurAttaquant) references Compte(idCompte);

alter table Essayer add constraint fk_joueurAttaque foreign key (joueurAttaque) references Compte(idCompte);

alter table Participer add constraint fk_joueur foreign key (joueur) references Compte(idCompte);

alter table Participer add constraint fk_challenge foreign key (challenge) references Challenge(idChallenge);