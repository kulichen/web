mysql --host=localhost --user=kulichen --password=Eng6eeCh --database=kulichen

CREATE TABLE tableimg (
id int NOT NULL AUTO_INCRIMENT,
name varchar(255) NOT NULL,
caption varchar(255) NOT NULL,
PRIMARY KEY (id)
);

INSERT INTO tableimg (name, caption) VALUES ('Машина';'ВАЗ 21093');