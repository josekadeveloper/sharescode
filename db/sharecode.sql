
------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS users CASCADE;

CREATE TABLE users
(
    id         bigserial     PRIMARY KEY
  , is_deleted boolean       NOT NULL DEFAULT false
);

DROP TABLE IF EXISTS portrait CASCADE;

CREATE TABLE portrait
(
    id             bigserial     PRIMARY KEY REFERENCES users (id) 
  , is_admin       boolean       NOT NULL DEFAULT false
  , nickname       varchar(255)  NOT NULL UNIQUE
  , password       varchar(255)  NOT NULL
  , date_register  timestamp     NOT NULL DEFAULT current_timestamp
  , email          varchar(255)  NOT NULL UNIQUE
  , repository     varchar(255)  NOT NULL UNIQUE
  , prestige_port  varchar(255)  NOT NULL DEFAULT 'Initiate'
  , sex            varchar(255)  NOT NULL 
);

DROP TABLE IF EXISTS prestige CASCADE;

CREATE TABLE prestige
(
    id              bigserial    PRIMARY KEY
  , type_prestige   varchar(255) NOT NULL
  , antiquity       timestamp
  , score           smallint     NOT NULL DEFAULT 0
  , users_id        bigint       REFERENCES users (id)  
);

DROP TABLE IF EXISTS query CASCADE;

CREATE TABLE query
(
    id              bigserial    PRIMARY KEY
  , title           varchar(255) NOT NULL
  , explanation     text         NOT NULL
  , date_created    timestamp    NOT NULL DEFAULT current_timestamp
  , is_closed       boolean
  , users_id        bigint       REFERENCES users (id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS answer CASCADE;

CREATE TABLE answer
(
    id              bigserial    PRIMARY KEY
  , content         varchar(255) NOT NULL
  , date_created    timestamp    NOT NULL DEFAULT current_timestamp
  , query_id        bigint       NOT NULL REFERENCES query (id) ON DELETE CASCADE
  , users_id        bigint       REFERENCES users (id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS reminder CASCADE;

CREATE TABLE reminder
(
    id              bigserial    PRIMARY KEY
  , title           varchar(255) NOT NULL
  , dispatch        varchar(255) NOT NULL
  , date_created    timestamp    NOT NULL DEFAULT current_timestamp
  , is_read         boolean      NOT NULL DEFAULT false
  , users_id        bigint       REFERENCES users (id)
);

--- Fixtures ---

INSERT INTO users (is_deleted)
VALUES (false);

INSERT INTO portrait (is_admin, nickname, password, date_register, email, repository, prestige_port, sex)
VALUES (true, 'admin', crypt('admin', gen_salt('bf', 10)), '2021-04-12 19:10:00', 'jose@gmail.com', 'https://github.com/joseckk', 'Initiate', 'Men');

INSERT INTO prestige (type_prestige, score, users_id)
VALUES ('Initiate', 0, null),
       ('Regular', 32, null),
       ('Junior', 89, null),
       ('Senior', 150, null),
       ('Programmer', 300, null);