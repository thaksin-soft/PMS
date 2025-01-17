PGDMP     &                    {            pp2022    9.6.1    14.7     q           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            r           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            s           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            t           1262    3063605    pp2022    DATABASE     j   CREATE DATABASE pp2022 WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_United States.1252';
    DROP DATABASE pp2022;
                postgres    false            u           0    0    pp2022    DATABASE PROPERTIES     /   ALTER DATABASE pp2022 SET work_mem TO '512MB';
                     postgres    false            �           1259    3067089    ic_category    TABLE     )  CREATE TABLE public.ic_category (
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
    DROP TABLE public.ic_category;
       public            postgres    false            �           1259    3069133    ic_category_roworder_seq    SEQUENCE     �   CREATE SEQUENCE public.ic_category_roworder_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.ic_category_roworder_seq;
       public          postgres    false    431            v           0    0    ic_category_roworder_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.ic_category_roworder_seq OWNED BY public.ic_category.roworder;
          public          postgres    false    646            �           2604    3074763    ic_category roworder    DEFAULT     |   ALTER TABLE ONLY public.ic_category ALTER COLUMN roworder SET DEFAULT nextval('public.ic_category_roworder_seq'::regclass);
 C   ALTER TABLE public.ic_category ALTER COLUMN roworder DROP DEFAULT;
       public          postgres    false    646    431            m          0    3067089    ic_category 
   TABLE DATA           �   COPY public.ic_category (ignore_sync, is_lock_record, roworder, code, name_1, name_2, status, guid_code, create_date_time_now) FROM stdin;
    public          postgres    false    431          w           0    0    ic_category_roworder_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.ic_category_roworder_seq', 902, true);
          public          postgres    false    646            �           2606    3089889    ic_category ic_category_pk_code 
   CONSTRAINT     _   ALTER TABLE ONLY public.ic_category
    ADD CONSTRAINT ic_category_pk_code PRIMARY KEY (code);
 I   ALTER TABLE ONLY public.ic_category DROP CONSTRAINT ic_category_pk_code;
       public            postgres    false    431            �           1259    3090887    ic_category_pk_code_idx    INDEX     �   CREATE INDEX ic_category_pk_code_idx ON public.ic_category USING btree (code);

ALTER TABLE public.ic_category CLUSTER ON ic_category_pk_code_idx;
 +   DROP INDEX public.ic_category_pk_code_idx;
       public            postgres    false    431            �           1259    3090888    ic_category_roworder_idx    INDEX     T   CREATE INDEX ic_category_roworder_idx ON public.ic_category USING btree (roworder);
 ,   DROP INDEX public.ic_category_roworder_idx;
       public            postgres    false    431            m      x��\�n�]�_A�*,NW�[�dI��m� `jH�@;iI��@ C�-�����"_�S�]���-yE�NwW�s뾊ݤ���N�NL��?�y��o&�h�w}�%�-)�BmK���LZ+;���!C��rq�\��\�-o��9�y�\-w����n���-�<TT9Y�=[.�/�h( w�����W.��k�6�ܫ��&���W� �ހ���yH=���þ�;������c��e��ݫ���rq��o�-�<  ?!j܆;��� Nx f҉������x��p!Fge�nbf9L�����/_'b�/�.��~���>�7]H��@z�\��7�G[����時�Dhև.wA��-�«�|�^.��>^�w�Vv���"���?���aCA�l��!���^�Ҳ^eS��t�;-K>%�H�#z�=�:�uqx��1�R�H���on2n�ZR�p�d>�/Ì��y�Q����D��y����]�;&�}�6�w)���.>�
*\���n|Ã���Q��O�DIT��n�(h��G�#{�}�I��I���F�C�}��z�l8�*��Z�Fl�FyxPs�W�x�[��j{���J��_o��P<�Lq%p7?p��!�>�iNK�qD�X�E��yH�P�#R�O�Y.Z��]�g��~Ko�Z�"����0W�ܗ}|�k��W��h���3�=�h͟�\$UGS�B5x���{��E�b���U����1N�u�e2��O4�����<������
��Y��ȗo�Ie��^��vI5��?6�<U��)�D�p+��O��$_.<��-o(Ȩz�Vr�vi�C�eg��8���U�Ma�1��{�>~��SY�*��oH�tt�5�Q�T���:�ձ��Jn���o�\V}����8��(�k�<�Qz��'*���#LӉii?(Z\q��rY����i��~�L�o�2���>�ëV�=&o�x��zŘ����5��5�q�������2�����t`��������`�J������+��:HA)�sۭ�`_8�Л	z;��L��Ax&�k�t���� 9�G������$����׼�@{&��4S
��}�x���y��P�Ȁg�=�f��K����
��"3���y���,-w���Tċn����c\rW�CW&n1C �f������< �݊���i��mͶ��Q6,�he�dN�{Śuہ'6���-č�;���8`͈A�Ɗ[;��4)�D�����vXY�"�i�r����I��>p}z�����n��q�3���#��H�X& L��KHqD���͉�4�r��D��#��Tz�5����Z&:]!ѳ�����DV�>�;8aS�6z<)�$�Nk�t�>NŊ|� �����0��T� �s�1.Z�w�����b�]=:��x�`����$@o�ף�XV��^V������F�W�&���l>{=Y�9����������ѡ����=h���8�q�a���m>zW��槛�y��AI�S>��᝼4lZ�f"�@�ô7,���T[���V���$;$�ٯ⍖F�z�Q����0��y������9h��gb�s3oZJbt�)�aNL��p#2+5FWqo8C����P�/9bH2+ua���sm�4��`"U���V��T�+0?q�@���n�:4E7�>R��VR�.[�x1tV���q��K=�2[�2oJ�+,�jk�v���9o4�Jget�V��`i(��
!�H)p5��/r��;�qP d(g����)�i�ԧ:�M�D��j0)��B��C�0㺡�	u���e���!�RQ�(�M��}A{�P6�A�?T-��Xp��
%����zy�-��4�*G��C�
k�L���-I���4�){s���:C�`�4,�\��\f��3���Q�Xy�U�s�6��&&�8K%������ΠU�$TF_�To4XIU�8:n�������K����Fk�D*�\���\5�̀�T�G�p�2����h�T�}Tʣ�0���N-�G���ژ	<��t�m�����?K�Ϝw
�M��A���m@����DF�Pe������R���G�l-��J�/%�r�;e�R=ډ��S�cE�%�� p.B]宋9�c�-ȧS��~&H�,;�O��������CZ��q�~ް�80F�l�i������P�KfOK����2�CR�7�ѩуҽ��7�Q�2�x���PT�K�

Q�;��̇�14�e�,��촋C}$zFT��~�?��z00�B��m"��a({��Z�Ww�5:���G�^�����T�qF���q�QO��uc=�j�C0����a^���^��{�åg�5���`��G�t��An��zp8�T��φ��D��s�27�E�-k]:��L���w]���uhj40�V�u o(ٌ�5���U
lϠ�E�u�m(�$���AO*�T���Y=��ˮg�X+
�f�e\º�V����@XWz�=�c��	P�*8�d���������;�����5w����ʋ�T��p� }�}��Re�~/�cjN��T���w\�"G�񉟛uL��}�����_ȁ�=����{9]P�'u[�A�^)��D,���I%z�8���Ľ�. |ϵ��.g1��;�����g�V�A�Q��롇\��{>+q�"<HH"W�ni
X�����N��Ps�?�z����ꡣ�T��]�ʤj;�R�;%������|IW����&������*�cͻ��3��hu��W�ۘK�����Jj|e�ӮRh.(}�-�a��M"�`���W�&��70HO%�|��~2�OL���]�<AT�:���Cz���2@��5ZA)T;�Аu
��z����"���d;�Ӱ�b��Z�~��-m<)&��R�sN��b��)�[6�d�RS5�>n	Ԕ+g�j&�����g�!!*���.:t��)�!H�y�or,�+w�S <����ivء��7Ri����^h9s�4NŻǴ�;b�:]J�e�5�	8>Smnc'1�
]���sXţ�s�JEd�Gܛ�m�ՠ��^_�d�4X,7��-Ν����6_�`���
0w󜢘�S�<ThBnl����K�l�����<��@=r�'�4}��@Or�';��J5���ـ���9�9��;�c 59~�X��D4vv�@|j��s�OV�4�@|j��ѫt (��6Y�95z�8����s���F#�ǹA:uOW��7��<Km!5�F�V�������қNp�>�	�S>W~���P�J��7u�Y�tZQ%A��qʣ�L��2���ތ/>��,dA����S�R�b�=�l��q��΍%���+���ˉ-�+ʩ0�Bnk?�׳t9�ͤ�]ɴƃ(7�;m$�Q�>��{N��Y�^h�pKz*���o�z��:;h��Ձg)kSn�$ mg�J/D|6p�#��+`s��A3t��4�J���f��|�e��+w&�zpU��Yg���!%:7��Sb�u�Y��i�/�-��7pO��G7���ܑA#��M�J�t��V	zӣ;� }���:gCBw�v*ĶV���:/���РI=�R�h2�)�7������߯�������n���(dܞN[���D�tY����\+c����(,X;�2x]O��"�l���>�$ń'ο��T(����9B*�<�6�f�{���a���U�:��� ^	^�0��2�;�֛�������sk�v�-�m%g�߫���9K���^�֮RGl+��μԶ~:fYZ�_����"谓۝�u�1}e�6�L����A��K7@��H�~�Et�2���I���6Ǭ������{��^n�jf{D~0,�o�:>8>R������H�l9�v���y�UĞ��z�:o��b7�Bl[}�4�b��%��gL0ߎ�|Ɓ���h��	�������Pm:Z$9��[]D� "1S�I��փ۶����� nߩ>�_ 1  l��Q��*n�f�b%�J<Xn�����gl}_�����+bZ��Eh�w_��q纬�5��K��/Ɯ�֍���؊��
�+A$v<��/?g��X�R�. �L	�tR���l��9�_��`�ۣ�� !�1�QW�*��)R�]'�`Vf0��%�z(�>�[ZU7�uu�k@�i�5�07�柸�~�it{���\'{�����X���ϐ-l13���;H0�C�=y��K& �k۹dK<���!�ٰ0}�	��F�-�$Z�i�;�˥�/�Z�'���3)w��p1��9a�5��ogO�<�KU�     