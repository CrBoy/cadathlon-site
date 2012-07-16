CREATE TABLE teams (
	tid integer primary key,
	team_name varchar not null,
	record text,
	paper text
);
CREATE TABLE students (
	sid integer primary key,
	stu_name varchar not null,
	school varchar not null,
	grade varchar not null,
	phone char(10) not null,
	email varchar not null,
	address varchar not null,
	tid integer not null,
	foreign key(tid) references teams(tid)
);
CREATE TABLE advisors(
	aid integer primary key,
	advisor_name varchar not null,
	school varchar not null
);
CREATE TABLE advise(
	tid integer not null,
	aid integer not null,
	foreign key (tid) references teams(tid),
	foreign key (aid) references advisors(aid)
);
