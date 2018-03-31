--Tables

CREATE TABLE event (
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

CREATE TABLE "user" (
	id SERIAL NOT NULL,
  email text NOT NULL,
  name text NOT NULL,
	birthdate date,
	nr_warnings integer,
	password_hash text NOT NULL,
	profile_picture_path text,
	is_banned boolean NOT NULL,
	is_admin boolean NOT NULL
);

CREATE TABLE event_user (
	id_event integer NOT NULL,
  id_user integer NOT NULL,
	event_user_state text NOT NULL,
	CONSTRAINT event_user_state CHECK ((event_user_state = ANY (ARRAY['Going'::text, 'Invited'::text, 'Ignoring'::text, 'Owner'::text])))
);

CREATE TABLE "comment" (
	id SERIAL NOT NULL,
	id_event integer NOT NULL,
	id_user integer NOT NULL,
	comment_content text NOT NULL,
	"date" timestamp with time zone DEFAULT now()
);

CREATE TABLE poll (
	id SERIAL NOT NULL,
	id_event integer NOT NULL,
	id_user integer NOT NULL,
	description text,
	question text NOT NULL
);

CREATE TABLE answer (
	id SERIAL NOT NULL,
	id_poll integer NOT NULL,
	answer text NOT NULL
);

CREATE TABLE answer_user (
	id_answer integer NOT NULL,
	id_user integer NOT NULL
);

CREATE TABLE "path"(
	id SERIAL NOT NULL,
	path_value text NOT NULL,
	multimedia_type text NOT NULL
	CONSTRAINT multimedia_type CHECK ((multimedia_type = ANY (ARRAY['Picture'::text, 'Video'::text])))
);

CREATE TABLE event_path(
	id_path integer NOT NULL,
	id_event integer NOT NULL
);

CREATE TABLE report(
	id SERIAL NOT NULL,
	id_user integer NOT NULL,
	description text
);

-- Primary Keys and Uniques

ALTER TABLE ONLY event
    ADD CONSTRAINT event_pkey PRIMARY KEY (id);

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_email_key UNIQUE (email);

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);

ALTER TABLE ONLY event_user
    ADD CONSTRAINT event_user_pkey PRIMARY KEY (id_event,id_user);

ALTER TABLE ONLY "comment"
    ADD CONSTRAINT comment_pkey PRIMARY KEY (id);

ALTER TABLE ONLY poll
    ADD CONSTRAINT poll_pkey PRIMARY KEY (id);

ALTER TABLE ONLY answer
    ADD CONSTRAINT answer_pkey PRIMARY KEY (id);

ALTER TABLE ONLY answer_user
    ADD CONSTRAINT answer_user_pkey PRIMARY KEY (id_answer,id_user);

ALTER TABLE ONLY "path"
    ADD CONSTRAINT path_pkey PRIMARY KEY (id);

ALTER TABLE ONLY event_path
    ADD CONSTRAINT event_path_pkey PRIMARY KEY (id_path);

ALTER TABLE ONLY report
    ADD CONSTRAINT report_pkey PRIMARY KEY (id);


-- Foreign Keys

ALTER TABLE ONLY event_user
  ADD CONSTRAINT event_user_id_event_fkey FOREIGN KEY (id_event) REFERENCES event(id) ON UPDATE CASCADE;

ALTER TABLE ONLY event_user
  ADD CONSTRAINT event_user_id_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY "comment"
	ADD CONSTRAINT comment_id_event_fkey FOREIGN KEY (id_event) REFERENCES event(id) ON UPDATE CASCADE;

ALTER TABLE ONLY "comment"
	ADD CONSTRAINT comment_id_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY poll
	ADD CONSTRAINT poll_id_event_fkey FOREIGN KEY (id_event) REFERENCES event(id) ON UPDATE CASCADE;

ALTER TABLE ONLY poll
	ADD CONSTRAINT poll_id_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answer
	ADD CONSTRAINT answer_id_poll_fkey FOREIGN KEY (id_poll) REFERENCES poll(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answer_user
	ADD CONSTRAINT answer_user_id_answer_fkey FOREIGN KEY (id_answer) REFERENCES answer(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answer_user
	ADD CONSTRAINT answer_user_id_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY event_path
	ADD CONSTRAINT event_path_id_event_fkey FOREIGN KEY (id_event) REFERENCES event(id) ON UPDATE CASCADE;

ALTER TABLE ONLY event_path
	ADD CONSTRAINT event_path_id_path_fkey FOREIGN KEY (id_path) REFERENCES "path"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY report
	ADD CONSTRAINT report_id_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;


--Triggers

	CREATE FUNCTION uninvited_comment() RETURNS TRIGGER AS
	$BODY$
	BEGIN
	  IF EXISTS (SELECT * FROM event_user
			INNER JOIN event on event.id = event_user.id_event
			WHERE event.event_visibility = 'Private'
			 	AND (event_user.event_user_state != 'Invited' OR event_user.event_user_state != 'Owner')
				AND NEW.id_event = event.id AND NEW.id_user = event_user.id_user) THEN
	    RAISE EXCEPTION 'An uninvited user cannot comment on a private event.';
	  END IF;
	  RETURN NEW;
	END
	$BODY$
	LANGUAGE plpgsql;

	CREATE TRIGGER uninvited_comment
	  BEFORE INSERT OR UPDATE ON "comment"
	  FOR EACH ROW
	    EXECUTE PROCEDURE uninvited_comment();

	CREATE FUNCTION warning_ban() RETURNS TRIGGER AS
	$BODY$
	BEGIN
	  IF EXISTS (SELECT * FROM "user"
			WHERE "user".nr_warnings = 3
				AND "user".is_banned = false) THEN
	    RAISE EXCEPTION 'A user with 3 warnings must be banned.';
	  END IF;
	  RETURN NEW;
	END
	$BODY$
	LANGUAGE plpgsql;

	CREATE TRIGGER warning_ban
	  BEFORE UPDATE ON "user"
	  FOR EACH ROW
	    EXECUTE PROCEDURE warning_ban();

	CREATE FUNCTION event_in_past() RETURNS TRIGGER AS
	$BODY$
	BEGIN
	  IF (NEW.event_start < NOW()::timestamp )THEN
	    RAISE EXCEPTION 'An event must not have a start date in the past';
	  END IF;
	  RETURN NEW;
	END
	$BODY$
	LANGUAGE plpgsql;

	CREATE TRIGGER event_in_past
	  BEFORE INSERT OR UPDATE ON event
		FOR EACH ROW
	  	EXECUTE PROCEDURE event_in_past();
