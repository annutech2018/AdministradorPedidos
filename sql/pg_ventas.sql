CREATE TABLE public.tbl_usuario
(
  usuario_id serial,
  usuario_nombre character varying(20),
  usuario_password character varying(20),
  usuario_tipo integer,
  usuario_fecha timestamp without time zone DEFAULT now(),
  usuario_saldo integer,
  usuario_creador integer,
  CONSTRAINT tbl_usuario_pkey PRIMARY KEY (usuario_id),
  CONSTRAINT tbl_usuario_usuario_nombre_key UNIQUE (usuario_nombre)
);
CREATE TABLE public.tbl_producto
(
  producto_id bigint NOT NULL,
  producto_nombre character varying(100),
  producto_descripcion text,
  producto_precio integer,
  producto_fecha timestamp without time zone,
  producto_usuario integer,
  CONSTRAINT tbl_producto_pkey PRIMARY KEY (producto_id)
);
CREATE TABLE public.tbl_log
(
  log_id serial,
  log_resumen text,
  log_usuario integer,
  log_fecha timestamp without time zone,
  log_nombre_equipo character varying(20),
  log_ip character varying(20),
  log_tipo integer,
  CONSTRAINT tbl_log_pkey PRIMARY KEY (log_id)
);
CREATE TABLE public.tbl_cliente
(
  cliente_rut character varying(20) NOT NULL,
  cliente_nombre character varying(20),
  cliente_apellido character varying(20),
  cliente_mail text,
  cliente_telefono character varying(20),
  cliente_direccion text,
  cliente_fecha_creacion timestamp without time zone DEFAULT now(),
  cliente_usuario integer,
  CONSTRAINT tbl_cliente_pkey PRIMARY KEY (cliente_rut)
);
CREATE TABLE public.tbl_folio
(
  folio_id serial,
  folio_codigo character varying(100),
  folio_fecha timestamp without time zone DEFAULT now(),
  folio_tipo integer, -- TIPO 0 = BOLETA...
  folio_estado integer DEFAULT 0,
  CONSTRAINT tbl_folio_pkey PRIMARY KEY (folio_id),
  CONSTRAINT tbl_folio_folio_codigo_key UNIQUE (folio_codigo)
);

CREATE TABLE public.tbl_venta
(
  venta_id integer NOT NULL DEFAULT nextval('tbl_venta_venta_id_seq'::regclass),
  venta_monto integer,
  venta_efectivo integer,
  venta_vuelto integer,
  venta_cliente character varying(20),
  venta_usuario integer,
  venta_fecha timestamp without time zone,
  venta_folio character varying(100),
  CONSTRAINT tbl_venta_pkey PRIMARY KEY (venta_id),
  CONSTRAINT tbl_venta_venta_usuario_fkey FOREIGN KEY (venta_usuario)
      REFERENCES public.tbl_usuario (usuario_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE public.tbl_detalle
(
  detalle_id serial,
  detalle_producto bigint,
  detalle_cantidad integer,
  detalle_venta integer,
  CONSTRAINT tbl_detalle_pkey PRIMARY KEY (detalle_id),
  CONSTRAINT tbl_detalle_detalle_producto_fkey FOREIGN KEY (detalle_producto)
      REFERENCES public.tbl_producto (producto_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT tbl_detalle_detalle_venta_fkey FOREIGN KEY (detalle_venta)
      REFERENCES public.tbl_venta (venta_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE public.tbl_configuracion
(
  configuracion_id serial,
  configuracion_nombre text,
  configuracion_valor text,
  CONSTRAINT tbl_configuracion_pkey PRIMARY KEY (configuracion_id)
);
CREATE TABLE public.tbl_credito
(
  credito_id serial,
  credito_total integer,
  credito_saldo integer,
  credito_cliente character varying(20),
  credito_creacion timestamp without time zone DEFAULT now(),
  CONSTRAINT tbl_cuenta_pkey PRIMARY KEY (credito_id),
  CONSTRAINT tbl_cuenta_cuenta_cliente_fkey FOREIGN KEY (credito_cliente)
      REFERENCES public.tbl_cliente (cliente_rut) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);



