PGDMP         '                {            pp2022    9.6.1    14.7     j           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            k           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            l           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            m           1262    3063605    pp2022    DATABASE     j   CREATE DATABASE pp2022 WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_United States.1252';
    DROP DATABASE pp2022;
                postgres    false            n           0    0    pp2022    DATABASE PROPERTIES     /   ALTER DATABASE pp2022 SET work_mem TO '512MB';
                     postgres    false            �           1259    3066429    ic_brand    TABLE     &  CREATE TABLE public.ic_brand (
    ignore_sync integer DEFAULT 0,
    is_lock_record integer DEFAULT 0,
    roworder integer NOT NULL,
    code character varying(25) DEFAULT ''::character varying NOT NULL,
    name_1 character varying(100) DEFAULT ''::character varying,
    name_2 character varying(100) DEFAULT ''::character varying,
    status smallint DEFAULT 0,
    guid_code character varying(35) DEFAULT ''::character varying,
    create_date_time_now timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone NOT NULL
);
    DROP TABLE public.ic_brand;
       public            postgres    false            �           1259    3069131    ic_brand_roworder_seq    SEQUENCE     ~   CREATE SEQUENCE public.ic_brand_roworder_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.ic_brand_roworder_seq;
       public          postgres    false    392            o           0    0    ic_brand_roworder_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.ic_brand_roworder_seq OWNED BY public.ic_brand.roworder;
          public          postgres    false    645            �           2604    3074762    ic_brand roworder    DEFAULT     v   ALTER TABLE ONLY public.ic_brand ALTER COLUMN roworder SET DEFAULT nextval('public.ic_brand_roworder_seq'::regclass);
 @   ALTER TABLE public.ic_brand ALTER COLUMN roworder DROP DEFAULT;
       public          postgres    false    645    392            f          0    3066429    ic_brand 
   TABLE DATA           �   COPY public.ic_brand (ignore_sync, is_lock_record, roworder, code, name_1, name_2, status, guid_code, create_date_time_now) FROM stdin;
    public          postgres    false    392   �       p           0    0    ic_brand_roworder_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.ic_brand_roworder_seq', 733, true);
          public          postgres    false    645            �           2606    3089887    ic_brand ic_brand_pk_code 
   CONSTRAINT     Y   ALTER TABLE ONLY public.ic_brand
    ADD CONSTRAINT ic_brand_pk_code PRIMARY KEY (code);
 C   ALTER TABLE ONLY public.ic_brand DROP CONSTRAINT ic_brand_pk_code;
       public            postgres    false    392            �           1259    3090885    ic_brand_pk_code_idx    INDEX     �   CREATE INDEX ic_brand_pk_code_idx ON public.ic_brand USING btree (code);

ALTER TABLE public.ic_brand CLUSTER ON ic_brand_pk_code_idx;
 (   DROP INDEX public.ic_brand_pk_code_idx;
       public            postgres    false    392            �           1259    3090886    ic_brand_roworder_idx    INDEX     N   CREATE INDEX ic_brand_roworder_idx ON public.ic_brand USING btree (roworder);
 )   DROP INDEX public.ic_brand_roworder_idx;
       public            postgres    false    392            f   �  x���ˊ�Nv�ק�"_�)t�]�22S�KI�U��f��v���3<3�1�+o�a�0T3�R�2�ʬv7|�sNe?��)�
(J#ҥ��T�����T���P=E�&�wA��m�a�>�I�T�;yA	����,�� S*M�r� (��So�Ͱz��4���\^C.���_,�d���^O�*3���AHg]���B�;���s�Ah�����;��\M���-��5�س^=��T7z!��6������T��Aₚ�l�8�=��Cj��ы���Q?k� (b�4^��BpL���l  ����Va)ٓ\�l!$#˗��8ʩ��3ڎ��{���M��e����CXH����C���~�߂�l  ��u�XIh�<���CX:���?#���n����r�u5��BHA�5�^,��A@�)�5TqR��A��C�r�A7]�b�蠫�꼃����o�f�g̻�:�Fw�����N�1����=:�\=���,��t��f��5B�0���U�b!$|h�7g�����2�~�+�KnKt��.B�-��+�Gʭ
7sf���q0�y��r��j��Gz� 4���Ǵ3�S�q�Pz��Mo���E����lY�T�\�g!ko���)j.e}[,�D��5�Bc.̃>� �{#f,��l�)��t'��ߠ�q/��v�g�� (���c�~\=�qOe��)ϫ�0饴��i�#XH��0wn��E�K)o{�X�V��ô9��<���K[�sen`�!�4>�n6���&$NIk� q�CwS��B�O*!*�މ�M��I�=�Q�`��'圜�E{9�=|Zko.A�X��y��ڷ<z�#_�=�Д����@@F.��|�s�K�.A�>g 	Ȕ|.�@@H�ҋ�EGc����N����BH���Kw8�ZL�/x�qC����S!N�� �Ng�/�C�@mwЋ���>ڛK�<����g!�g��O�� E���%�B"�Wk��_�/ձzY=�%�����ƨq�rw�t	�g,���@@N�*n.Au��f� Y��^�B��%H��O.A��g�v7Z-��@`B}�bg)�����nG����ԃ�����@(��.!�<�A�ܼ�BBZ� ������@@$C͛],���]}֋���ş�l  %���e<��F[.�r➔K�� ~�TG���X4U'3,B�Y��+9�=�`E�U�$����/_>��;�e��m���x��w����l  �OF�9�APNo��z{��������wo_���O�Β ���z{����{{�����,d��߾���뿾���;��}������ڱ������{�����t�yG?��e�#9�$�I�y��{s 0�`i�?�� y�iJ� 9�7�`�r��;�|�>�����N��B���8�1�G:�t-$�r�>czA\7X7	�����w�%��q#	9�{]��B�<����rΏ��6�j�w1�+y1��� .W�$���V�$��"���.A��e�$Oh����k� yF�F��嬾�M�;3=�\8�oVx	8
ho;�l�8
��Ky^,�(���K������]~�!,��c��C���v	��T��i��!,c�8��;ʩ�JP�!*�4�k:�G�8 �G0+㐕���a��X/#��BHD����@@L��4��:�:���R�vGy��=�et�L<�)o!��%H^Ё;��A�$`-��!!�.��A����N�\ܽ�����v�w�|���$I"R;H��/���.I22�/1h�$�ɴf�!��V�ܝ����Ӏ��%H�q����,In^�ĦK��n��tt��'�$M�X]�C��t��a6������{��8Tv6P��R���"H��<��;
Y���(��Z&��Ft���$m�C�1-o���������oz�T��0�21p��;�E=52�o ��37�g���v�m�ҹ:���w�d���!�;� q,_pN2y�{�2`��Y,�p)�T{yE�=�q)�]���Va9U��4R� ��T���"��-]��!K{~4�@���;�p|���c�-Bb��˧�b!$��g� qJ�e��՜�5��E��i��q� Tf6�I�X��nF�K�<$!c��4P��]���m9�b���%H�Pm�F/BR�/��m���9~��L��S�O$Y��=���&3y�`a@͙�3RSu\ ����ra���4�YmW=i� H�O��e}�c��|�v#j�!,�֜�l  c���AO,�)���J��#-�٪~���'U˹�tB��.]��A��v�GԎ�RwW=>DS�\��2�Ѿ�R־��3ꪺ�������`ez�@`A�햕#�r$���μ��pV�n"U��n.A�졒��BHL�&�_%d����������yA�����{ ���;=8�I���R������<Q�R߶.ArE�DxabG���K�<���2��YI��&� yJ���곅��+$�Yy��l!���o]B�I���%H�0]]���AfB�Bd�J[�i+�A��[i/w���0��ҝ/�;JE�ίCO/�q/$�i�������APA��K7�!P��>]�j��X��t��!��BS�����i��$�¸,��Ab.��Ǿx�20��9���~6�%@.��BfRu=�f��nA��S�$�\����=��ʧ��w�z����D�U���Yq�_'� yF��d��8��k�,�X����z<���K�<$��pF�J��v4�{ �Mg�gJ<��T�.A�vt	��:Z�$����n62l~!�ˁ�1�q9��.!r���\u���ƇBC��'^K%b���BpDW�ɗ��APL�rr	�'t5�1�w�ҵ�n5�C��d� (�k-$.��ß+6ʂ��Msش���!��P&����{s3Ze1�� (bu�$�饒���APB7�.�9�=�����Z���rz?��ϜG�����)_�Ϻ����M�x�m��<����ȹzy?��d���M�T��&U�ʏ�7\9���OA�	�3N�*H�<[0�g>�{���|�r�(�E�6NU�z4��$��!�.̧��'QE�/pB�=���xXѽ��]d��$��9?Ɋb�E��I���<�����U�&Lwa�K�m�Q-�ͨ�,ev�(�|�N�[�e?L(������vr���#s&a�2C:��6{q�`|�j�d�塊�d�T@��K�I��D�<��d��J�9�<�0�Cw�����֤A,eL):���b��sE3�K�q���Q����O�Y��T���Q���+�zW;[Wz�+����Iq͋vJq�۪���t��U�,T�������|��,�� _�"U�ME�_��>��#,.��HT��R��e��.RH~q�����wq0�����_����q�ɷAd��2��d!�(_0��h���m�'q�4E*Y+�_�}����������A%�X��R1�%� }��\��&̤\��6Pq�sD�2���w�77{��o������w*9�D���%I�U!˒����"���8�%\���ۚ�W�}����ܣG�p�3��&�&OC�PF!��;]�y�?��_����ږ�J�GM�\��b�mW��LH��
E�"iO��x�Ǌ���"Y�Xr�|�߀�\�<C�mY�>�l��Ç?8�;�     