






SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;



CREATE TABLE administrative_unit_inventories_subsecretary (
    id integer NOT NULL,
    administrative_unit_id integer NOT NULL,
    inventory_id integer NOT NULL,
    subsecretary_id integer NOT NULL,
    body text,
    created_at date DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE administrative_unit_inventories_subsecretary OWNER TO duarte;





ALTER TABLE administrative_unit_inventories_subsecretary ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME administrative_unit_inventories_subsecretary_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);






CREATE TABLE administrative_units (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    subsecretary_id integer NOT NULL,
    status boolean DEFAULT true,
    created_at date DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE administrative_units OWNER TO duarte;





ALTER TABLE administrative_units ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME administrative_units_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);






CREATE TABLE inventories (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    user_id integer NOT NULL,
    created_at date DEFAULT CURRENT_TIMESTAMP,
    status boolean DEFAULT false,
    code character varying
);


ALTER TABLE inventories OWNER TO duarte;





ALTER TABLE inventories ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME inventories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);






CREATE TABLE subsecretaries (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    status boolean DEFAULT true,
    created_at date DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE subsecretaries OWNER TO duarte;





ALTER TABLE subsecretaries ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME subsecretaries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);






CREATE TABLE users (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(100) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    name character varying(100) NOT NULL,
    last_name character varying(100) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    role integer DEFAULT 0 NOT NULL,
    administrative_unit_id integer
);


ALTER TABLE users OWNER TO duarte;





CREATE SEQUENCE users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE users_id_seq OWNER TO duarte;





ALTER SEQUENCE users_id_seq OWNED BY users.id;






ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);






COPY administrative_unit_inventories_subsecretary (id, administrative_unit_id, inventory_id, subsecretary_id, body, created_at) FROM stdin;
22	33	78	67	\N	2023-11-24
23	33	79	67	\N	2023-11-24
21	34	77	67	[{"section":"1S","serie":"1S.2","no_ex":"1","formule":"SF\\/OSF\\/1S\\/1S.2","name":"Minutario - Oficios","total_legajos":"1","total_files":"109","observations":"S\\/0","files_date":["2023-10-18","2023-12-18"],"no":1},{"section":"12","serie":"1S.2","no_ex":"2","formule":"SF\\/OSF\\/1S\\/1S.2","name":"Minutario - Tarjetas","total_legajos":"2","total_files":"191","observations":"S\\/O","files_date":["2023-11-08","2023-12-26"],"no":2}]	2023-11-24
24	33	80	67	\N	2023-11-24
\.






COPY administrative_units (id, name, subsecretary_id, status, created_at) FROM stdin;
32	Secretaría Particular/Secretaría de Finanzas	67	t	2023-11-24
33	Unidad de Informática/Subsecretaría de Tesorería	67	t	2023-11-24
34	Dirección General de Enlace Interinstitucional/Coordinación de Gestión Gubernamental	67	t	2023-11-24
35	Subsecretaría de Administración/Secretaría de Finanzas	67	t	2023-11-24
36	Subsecretaría de Planeación y Presupuesto/Secretaría de Finanzas	67	t	2023-11-24
37	Secretaría de Finanzas/Secretaría de Finanzas	67	f	2023-11-24
\.






COPY inventories (id, name, user_id, created_at, status, code) FROM stdin;
78	INVENTARIO GENERAL DE ARCHIVO	154	2023-11-24	f	50000000000000
79	INVENTARIO GENERAL DE ARCHIVO	154	2023-11-24	f	asdasdada
77	INVENTARIO GENERAL DE ARCHIVO	154	2023-11-24	f	20700001000000S
80	INVENTARIO GENERAL DE ARCHIVO	154	2023-11-24	f	222222222222222
\.






COPY subsecretaries (id, name, status, created_at) FROM stdin;
67	SECRETARíA DE FINANZAS	t	2023-11-24
68	UNIDAD DE INFORMáTICA/SUBSECRETARíA DE TESORERíA	t	2023-11-24
\.






COPY users (id, email, password, created_at, name, last_name, status, role, administrative_unit_id) FROM stdin;
265	eduarte@gmail.com	$2y$12$TTyhMb7VoU51v3Ze/ocECOp0kC4wuOiiTExTf7NtbeTeQHqIYDOpi	2023-11-24 13:08:11.797546	Eduardo	Duarte	t	1	\N
264	duarte@gmail.com	$2y$12$dlslI4zw7pV4/5ztbaeqUu/r8UixveOswzolsjmbW5v0OJWVsunue	2023-11-24 13:04:27.159684	Eduardo	Duarte	t	1	32
154	duarte@xmail.com	$2y$12$EnuS0i9iICSUdTBoBM3yVeWzCKUBhvBidJWteHJ7uixzGul36mhfy	2023-11-03 10:48:14.932161	x<z<zx<zx<z	Duarte	t	1	\N
\.






SELECT pg_catalog.setval('administrative_unit_inventories_subsecretary_id_seq', 24, true);






SELECT pg_catalog.setval('administrative_units_id_seq', 37, true);






SELECT pg_catalog.setval('inventories_id_seq', 80, true);






SELECT pg_catalog.setval('subsecretaries_id_seq', 68, true);






SELECT pg_catalog.setval('users_id_seq', 265, true);






ALTER TABLE ONLY administrative_unit_inventories_subsecretary
    ADD CONSTRAINT administrative_unit_inventories_subsecretary_pkey PRIMARY KEY (id);






ALTER TABLE ONLY administrative_units
    ADD CONSTRAINT administrative_units_pkey PRIMARY KEY (id);






ALTER TABLE ONLY inventories
    ADD CONSTRAINT inventories_pkey PRIMARY KEY (id);






ALTER TABLE ONLY subsecretaries
    ADD CONSTRAINT subsecretaries_pkey PRIMARY KEY (id);






ALTER TABLE ONLY users
    ADD CONSTRAINT users_email_key UNIQUE (email);






ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);






ALTER TABLE ONLY users
    ADD CONSTRAINT fk_administrative_unit FOREIGN KEY (administrative_unit_id) REFERENCES administrative_units(id);






ALTER TABLE ONLY administrative_unit_inventories_subsecretary
    ADD CONSTRAINT fk_administrative_unit FOREIGN KEY (administrative_unit_id) REFERENCES administrative_units(id);






ALTER TABLE ONLY administrative_unit_inventories_subsecretary
    ADD CONSTRAINT fk_inventory FOREIGN KEY (inventory_id) REFERENCES inventories(id);






ALTER TABLE ONLY administrative_units
    ADD CONSTRAINT fk_subsecretary FOREIGN KEY (subsecretary_id) REFERENCES subsecretaries(id);






ALTER TABLE ONLY administrative_unit_inventories_subsecretary
    ADD CONSTRAINT fk_subsecretary FOREIGN KEY (subsecretary_id) REFERENCES subsecretaries(id);






ALTER TABLE ONLY inventories
    ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id);






