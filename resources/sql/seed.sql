--TODO introduce the database transaction from a9
--TODO fix uninvited_comment trigger

--Tables
DROP TABLE IF EXISTS answers CASCADE;
DROP TABLE IF EXISTS answer_user CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS event_path CASCADE;
DROP TABLE IF EXISTS event_user CASCADE;
DROP TABLE IF EXISTS events CASCADE;
DROP TABLE IF EXISTS paths CASCADE;
DROP TABLE IF EXISTS polls CASCADE;
DROP TABLE IF EXISTS reports CASCADE;
DROP TABLE IF EXISTS users CASCADE;

DROP FUNCTION IF EXISTS uninvited_comment();
DROP TRIGGER IF EXISTS  uninvited_comment ON comments;
DROP FUNCTION IF EXISTS warning_ban();
DROP TRIGGER IF EXISTS  warning_ban ON users;
DROP FUNCTION IF EXISTS event_in_past();
DROP TRIGGER IF EXISTS  event_in_past ON events;

CREATE TABLE events (
	id SERIAL NOT NULL,
	description text,
	title text NOT NULL,
	event_start timestamp with time zone,
	event_end timestamp with time zone CHECK (event_start < event_end),
	event_visibility text NOT NULL,
	CONSTRAINT event_visibility CHECK ((event_visibility = ANY (ARRAY['Public'::text, 'Private'::text]))),
	event_type text NOT NULL,
	CONSTRAINT event_type  CHECK ((event_type = ANY (ARRAY['Trip'::text, 'Party'::text, 'Sport'::text, 'Education'::text, 'Culture'::text, 'Birthday'::text]))),
	gps text,
	is_deleted boolean NOT NULL
);

CREATE TABLE users (
	id SERIAL NOT NULL,
  email text NOT NULL,
  name text NOT NULL,
	birthdate date,
	nr_warnings integer,
	password text,
	profile_picture_path text,
	is_banned boolean,
	is_admin boolean,
	remember_token text
);

CREATE TABLE event_user (
	id_event integer NOT NULL,
  id_user integer NOT NULL,
	event_user_state text NOT NULL,
	CONSTRAINT event_user_state CHECK ((event_user_state = ANY (ARRAY['Deciding'::text,'Going'::text, 'Ignoring'::text, 'Owner'::text]))),
	is_invited boolean
);

CREATE TABLE comments (
	id SERIAL NOT NULL,
	id_event integer NOT NULL,
	id_user integer NOT NULL,
	comment_content text NOT NULL,
	replyto integer NOT NULL,
	"date" timestamp with time zone DEFAULT now()
);

CREATE TABLE polls (
	id SERIAL NOT NULL,
	id_event integer NOT NULL,
	id_user integer NOT NULL,
	description text,
	question text NOT NULL
);

CREATE TABLE answers (
	id SERIAL NOT NULL,
	id_poll integer NOT NULL,
	answer text NOT NULL
);

CREATE TABLE answer_user (
	id_answer integer NOT NULL,
	id_user integer NOT NULL
);

CREATE TABLE paths(
	id SERIAL NOT NULL,
	path_value text NOT NULL,
	multimedia_type text NOT NULL
	CONSTRAINT multimedia_type CHECK ((multimedia_type = ANY (ARRAY['Picture'::text, 'Video'::text])))
);

CREATE TABLE event_path(
	id_path integer NOT NULL,
	id_event integer NOT NULL
);

CREATE TABLE reports(
	id SERIAL NOT NULL,
	id_user integer NOT NULL,
	description text
);

-- Primary Keys and Uniques
ALTER TABLE ONLY events
    ADD CONSTRAINT event_pkey PRIMARY KEY (id);

ALTER TABLE ONLY users
    ADD CONSTRAINT user_email_key UNIQUE (email);

ALTER TABLE ONLY users
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);

ALTER TABLE ONLY event_user
    ADD CONSTRAINT event_user_pkey PRIMARY KEY (id_event,id_user);

ALTER TABLE ONLY comments
    ADD CONSTRAINT comment_pkey PRIMARY KEY (id);

ALTER TABLE ONLY polls
    ADD CONSTRAINT poll_pkey PRIMARY KEY (id);

ALTER TABLE ONLY answers
    ADD CONSTRAINT answer_pkey PRIMARY KEY (id);

ALTER TABLE ONLY answer_user
    ADD CONSTRAINT answer_user_pkey PRIMARY KEY (id_answer,id_user);

ALTER TABLE ONLY paths
    ADD CONSTRAINT path_pkey PRIMARY KEY (id);

ALTER TABLE ONLY event_path
    ADD CONSTRAINT event_path_pkey PRIMARY KEY (id_path);

ALTER TABLE ONLY reports
    ADD CONSTRAINT report_pkey PRIMARY KEY (id);

-- Foreign Keys
ALTER TABLE ONLY event_user
  ADD CONSTRAINT event_user_id_event_fkey FOREIGN KEY (id_event) REFERENCES events(id) ON UPDATE CASCADE;

ALTER TABLE ONLY event_user
  ADD CONSTRAINT event_user_id_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY comments
	ADD CONSTRAINT comment_id_event_fkey FOREIGN KEY (id_event) REFERENCES events(id) ON UPDATE CASCADE;

ALTER TABLE ONLY comments
	ADD CONSTRAINT comment_id_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY polls
	ADD CONSTRAINT poll_id_event_fkey FOREIGN KEY (id_event) REFERENCES events(id) ON UPDATE CASCADE;

ALTER TABLE ONLY polls
	ADD CONSTRAINT poll_id_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answers
	ADD CONSTRAINT answer_id_poll_fkey FOREIGN KEY (id_poll) REFERENCES polls(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answer_user
	ADD CONSTRAINT answer_user_id_answer_fkey FOREIGN KEY (id_answer) REFERENCES answers(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answer_user
	ADD CONSTRAINT answer_user_id_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY event_path
	ADD CONSTRAINT event_path_id_event_fkey FOREIGN KEY (id_event) REFERENCES events(id) ON UPDATE CASCADE;

ALTER TABLE ONLY event_path
	ADD CONSTRAINT event_path_id_path_fkey FOREIGN KEY (id_path) REFERENCES paths(id) ON UPDATE CASCADE;

ALTER TABLE ONLY reports
	ADD CONSTRAINT report_id_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

--Triggers
	-- CREATE FUNCTION uninvited_comment() RETURNS TRIGGER AS
	-- $BODY$
	-- BEGIN
	--   IF EXISTS (SELECT * FROM event_user
	-- 		INNER JOIN events on events.id = event_user.id_event
	-- 		WHERE events.event_visibility = 'Private'
	-- 		 	AND (event_user.event_user_state != 'Going' OR event_user.event_user_state != 'Deciding' OR event_user.event_user_state != 'Owner')
	-- 			AND NEW.id_event = events.id AND NEW.id_user = event_user.id_user) THEN
	--     RAISE EXCEPTION 'An uninvited user cannot comment on a private event.';
	--   END IF;
	--   RETURN NEW;
	-- END
	-- $BODY$
	-- LANGUAGE plpgsql;
	--
	-- CREATE TRIGGER uninvited_comment
	--   BEFORE INSERT OR UPDATE ON comments
	--   FOR EACH ROW
	--     EXECUTE PROCEDURE uninvited_comment();

	CREATE FUNCTION warning_ban() RETURNS TRIGGER AS
	$BODY$
	BEGIN
	  IF EXISTS (SELECT * FROM users
			WHERE users.nr_warnings = 3
				AND users.is_banned = false) THEN
	    RAISE EXCEPTION 'A user with 3 warnings must be banned.';
	  END IF;
	  RETURN NEW;
	END
	$BODY$
	LANGUAGE plpgsql;

	CREATE TRIGGER warning_ban
	  BEFORE UPDATE ON users
	  FOR EACH ROW
	    EXECUTE PROCEDURE warning_ban();

	CREATE FUNCTION event_in_past() RETURNS TRIGGER AS
	$BODY$
	BEGIN
	  IF (NEW.event_start < NOW()::timestamp )THEN
	    RAISE EXCEPTION 'An events must not have a start date in the past';
	  END IF;
	  RETURN NEW;
	END
	$BODY$
	LANGUAGE plpgsql;

	CREATE TRIGGER event_in_past
	  BEFORE INSERT OR UPDATE ON events
		FOR EACH ROW
	  	EXECUTE PROCEDURE event_in_past();
