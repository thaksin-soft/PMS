PGDMP                         {         	   odienmall    9.6.1    14.7     u           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            v           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            w           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            x           1262    4281677 	   odienmall    DATABASE     m   CREATE DATABASE odienmall WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_United States.1252';
    DROP DATABASE odienmall;
                postgres    false            y           0    0 	   odienmall    DATABASE PROPERTIES     7   ALTER DATABASE odienmall SET bytea_output TO 'escape';
                     postgres    false            �           1259    5042224    tb_attribute    TABLE       CREATE TABLE public.tb_attribute (
    roworder integer NOT NULL,
    code character varying,
    filedname character varying,
    line_number smallint,
    create_date_time_now timestamp without time zone DEFAULT now(),
    active smallint,
    filedname_lao character varying
);
     DROP TABLE public.tb_attribute;
       public            postgres    false            �           1259    5042222    tb_attribute_roworder_seq    SEQUENCE     �   CREATE SEQUENCE public.tb_attribute_roworder_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.tb_attribute_roworder_seq;
       public          postgres    false    1176            z           0    0    tb_attribute_roworder_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.tb_attribute_roworder_seq OWNED BY public.tb_attribute.roworder;
          public          postgres    false    1175            �           2604    5042227    tb_attribute roworder    DEFAULT     ~   ALTER TABLE ONLY public.tb_attribute ALTER COLUMN roworder SET DEFAULT nextval('public.tb_attribute_roworder_seq'::regclass);
 D   ALTER TABLE public.tb_attribute ALTER COLUMN roworder DROP DEFAULT;
       public          postgres    false    1175    1176    1176            r          0    5042224    tb_attribute 
   TABLE DATA           {   COPY public.tb_attribute (roworder, code, filedname, line_number, create_date_time_now, active, filedname_lao) FROM stdin;
    public          postgres    false    1176   �       {           0    0    tb_attribute_roworder_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.tb_attribute_roworder_seq', 1, true);
          public          postgres    false    1175            �           2606    5042233    tb_attribute tb_attribute_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.tb_attribute
    ADD CONSTRAINT tb_attribute_pkey PRIMARY KEY (roworder);
 H   ALTER TABLE ONLY public.tb_attribute DROP CONSTRAINT tb_attribute_pkey;
       public            postgres    false    1176            r   �  x��ջN�0���y�� ѹ�v�ga�RA%D��T��l�, 66&.bq_Ə�s(*�]U��!R����# ����T�" >���	bG�i]�F�V�
�>���~	�3�ǊD�ͯ�����w�"����孢C�)����?�_UZp� O����i�n�� m��ߘ�M\Ͱ�B���)���H�@NsS�iy�N'�����hW��!�lu�
�9���3�W.L�o"��bc&v����g� \��ݑ��@�4Y\�2w��FDY I�Yj,�<���fD�7$�1&щ�H� �ቄ�ʉ�t@qx��m$Rl�Drְ�=������~�̞ʔ�dj��2��Q�V������Ȏ�t�d2��(ttf#�s�x��Obj ¶M+�몪~ �02     