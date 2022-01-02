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
	idTentative int primary key not null AUTO_INCREMENT,
	tmp VARCHAR(2)
);


create table Essayer(
	codeEssaye int,
	tentative int not null,
	joueurAttaquant int not null,
	joueurAttaque int not null,
	challenge int not null,
	primary key(tentative,joueurAttaquant,joueurAttaque,challenge)
);



create table Participer(
	codeJoueur int,
	nbPoints int,
	challenge int not null,
	joueur int not null,
	primary key (challenge, joueur)
);

alter table Challenge add constraint fk_cAdmin foreign key (compteAdmin) references Compte(idCompte) ON UPDATE CASCADE ON DELETE CASCADE;

alter table Challenge add constraint fk_cJoueur foreign key (compteJoueur) references Compte(idCompte) ON UPDATE CASCADE ON DELETE CASCADE;

alter table Essayer add constraint fk_tentative foreign key (tentative) references Tentative(idTentative) ON UPDATE CASCADE ON DELETE CASCADE;

alter table Essayer add constraint fk_joueurAttaquant foreign key (joueurAttaquant) references Compte(idCompte) ON UPDATE CASCADE ON DELETE CASCADE;

alter table Essayer add constraint fk_joueurAttaque foreign key (joueurAttaque) references Compte(idCompte) ON UPDATE CASCADE ON DELETE CASCADE;

alter table Participer add constraint fk_joueur foreign key (joueur) references Compte(idCompte) ON UPDATE CASCADE ON DELETE CASCADE;

alter table Participer add constraint fk_challenge foreign key (challenge) references Challenge(idChallenge) ON UPDATE CASCADE ON DELETE CASCADE;

alter table Essayer add column trouve boolean;

alter table Compte add column nbPoints boolean;

