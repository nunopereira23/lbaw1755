--Tables

CREATE TABLE event (
	id SERIAL NOT NULL,
	description text,
	title text NOT NULL,
	event_start timestamp with time zone DEFAULT now(),
	event_end timestamp with time zone DEFAULT now() CHECK (event_start < event_end),
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
	id_comment integer NOT NULL,
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




	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	