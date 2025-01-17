PGDMP     5    -        
        {            pp_od_manage    9.6.1    14.7     $
           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            %
           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            &
           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            '
           1262    3250943    pp_od_manage    DATABASE     p   CREATE DATABASE pp_od_manage WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_United States.1252';
    DROP DATABASE pp_od_manage;
                postgres    false            �            1259    3251134    users    TABLE       CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    emp_id bigint,
    warehouse_code character varying(30),
    depend_id bigint,
    branch_code character varying(10),
    company character varying(100)
);
    DROP TABLE public.users;
       public            postgres    false            �            1259    3251140    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    225            (
           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    226            �	           2604    3251601    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    226    225             
          0    3251134    users 
   TABLE DATA           �   COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, emp_id, warehouse_code, depend_id, branch_code, company) FROM stdin;
    public          postgres    false    225   �       )
           0    0    users_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.users_id_seq', 204, true);
          public          postgres    false    226            �	           2606    3251347    users user_name_constraint 
   CONSTRAINT     U   ALTER TABLE ONLY public.users
    ADD CONSTRAINT user_name_constraint UNIQUE (name);
 D   ALTER TABLE ONLY public.users DROP CONSTRAINT user_name_constraint;
       public            postgres    false    225            �	           2606    3251349    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    225            �	           2606    3251351    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    225             
      x�}|Y��ʶ���W�����YOE@Di�F���A�~��U�U�/�$�F��d�9s̙��&��:.��q�7*�܎3�-���I���������sΖ�q$�˾k��⭦�w	�a+�C^c(j�EU�B�M�=�п �/D�� ���b���ϟ�@���ֳ/QY�/ݿ�;��Y�w��~�{k��ы��􎛥�/o�u�W_���@��p�>���B�0����?0>��ӷ��N�xq������p����m�j���6�b[j��v�#bk9)4�s%U�q��\����o���� �m�|��U�x�
�������@ :2���n���.�����$�ܗ�޲Û?C�c^	�����ء�ݛ���Z�=�n��)�0z�OD�%�p��W!^��`����+ӑWл���F�b�C�B#�<f�Ⱦ���m��Qj���,|����c��b����9�P~�v���Q�_C�Ğl>�	"Ʌca9z`�?�܉C/��Yz�	*!��a����Fa���6�NTv״I�e���&K
���0,������B�?�Mc�YS�4��֟�HR���Wg�Y��%���z0Z��P�݋}5lՠ��龱ɒ�.M�[7���x����bF�2ÉEj_���e�ՙ%���jW��Q�{
n�N>�
ҭ���xSl9 �z�7�1Z_3:�=�	��������O_$#��3KF2�;�x�z� ��+�u[�o�y�;��rkO�S�Y>�@g8��YOD�Yz�R�i]822f�lv[�=��{Z�����Rq�a��0o�f���5p�h�Q������������ph����<��z<g	�����e�*޳���6#��S����}J� z��)\s���'���>g
�id�nd�È�_fi+�M�]����B�I2��NJ\['�3N�IU��Z��2��4 �������b�,}�"�E������Β����Ww
�
�;-y��ԝ�d�,�8� B*˪��R~ĵ��s�F���ň��9VТ)ǟY*�������J�	^�
ŬMarp�=힘e�S���lPG������P������y}�-�9��G3��$�(�l�c��5־i���6=�53����bܑ����{�&�"g1�|�5�a?�v�7R���%�m��2�FD"���4H�f���;�F"�X�N�m�7)�Z�`�2k��˶�H=��8�^!`�YP�Ի^?��*�juI�*^J����D��&�S	���@_H��3\Ǘ��,�`�ꮓ�m��V��q,L��8��,�^�_��IY@���6�ǟY�-n���O��YB���C��Q�&e�I[�W���(k���)D[��=���b�<���æ�B�Yl�󗅄Z�e[L�4r��������QR+����k�ɬ��WA�r#�,�����T�pB���z}����AΈ��o����������|0_�r���De ��PW�?[ x�B�F_K{�9�Ķ-b�՚��aG�AS�Eܗ�z� �u�C�E���(�>�YN�zk��rjdۯ����Ɣ���P����M��5�P�z��[}�?8�A��P!���h�:RTIvX+&�,�m��4� ���P�Xq9k���v��zZ���O9w��xUR�TSlQ�
��؃Z�=�xPdhNS-Z�P[��Di� ITL��1���g1z{]���M��lg_�CA�x{��NCV*P[wF���@d�f���DPF�X���`@|���`ꗹ]���,)�=�*&�`p8.gpӃ6/E졢~��mJ� � O�Ie��+)N��۾b�g�
���X������ݛ�DD�$�1�讟je�@ѕ}?�pL}C1��D9�{��˨�����T�3n�U�����.��W�!zz�Dh�I;\q8�;���=wv-�~�Ɨ@�Y�x�ϰQ�G�Ϝ��;�^,C�my�`�D߽3��I�C^�: ��6
�$Z�\�|��TF|�$�_p2� �J�!h�p�5ET��\؟�,-���bE� ��
�������-@mI�̬���V"�*�e�"7��gG-̪�:�<�{�S-'�$�r�_�db��F�҄�m��lS>�g�۹9���g1�+r �z8\�D�T���ξ���_��w����n�*��6�%`ƴ��Z��"���kR�ւ�Ǥ��Y���A��Sp��������'��Gܡ�r� �ez2���硬i�q!1m�,y4�O��Z	r�p�����룙O�M!r�����(�̸r���"�`���	Q��cB� �q�KN�CB�A�Y�#y�
��3��!��|q��hs)��U�**�����C�kk@zr�^���~>o�7m��=n�a:��3���1���FR��E#�
by��KlNe��P����3�#r��4x�y�^�۸�e3}f_#�j5> �����Vq.�lUI�E�
)�]%Ð��tJ?�%'l�l�CGš(v�J�A�}s�+*V7�'�]>HF#���-N��?W����/B�3�.��|wg_K��;�#KJ�=J�Y�mt�j����v��v��%_JT�{��kI�9�g1~��T��ُf^�k��í+�"�PE\v
��0l�x%	(Zb,�3O}c�瓉���M*�G�������PS�>2z<g	�Xɺ���4�]ɷ����W�;� ,S��8*�_w�5Lԍ�:��OB�ds5�������OI��/��@Xk�De�ٺV�}fv�M��D�R����k_�+����>C{.F����}�s�J�f*7~�����p��R���ʱ�`k8lMeIGR��fsn�>˫��7���ߤ(~��Y�GE]��qu�c��v��eTV�Ba�g���p;_V�.�Y�
R������CnzxUޓ�j,4��y�] C���l;����.?��,;�Y�S��,?+�H��dP�G�^-7jNB��nGH��v�T����CA@�s�>�� ��p����s�QŹ'�;l꒕�#�����v+(jȡ�eMm���?E4�	)�������"�$Es
Q7m�&�o�g���&�E]ab���~D�r؁�-�=�Si�C�w���)=z��;�.�ݝ/lhu���`��lݻ�^�+��̥��+�<\	g�!>�$�u�U�	�����k��,x����,�k���1���v�%��"���:.l���%��Y�,�9��,F�a�������^<U��p�����j:Lt�n�Ý�2��Z5���]8����*�D%�Z��)����������D"o���g;K���=a���<�6��<Жz���[J��U)"bcvn��۹q�6���TuIj$�p�����J����v׶-O��A!Ác�/ז�IT렝�;����{�R���tj 5���i�0N��d��x�N힪�5���}���#�]�A����A�+D�����|��	���SN��b8��	�������:��-��6���	��/���"�s��M�\�2�-�:nk��E�G}��6�wzj�g�E��g�#i��ߢ�@���'�1��oΙ߂.eq�62R�;|H��"�+f����a�,=�d�=R�{F�ܵ�`��������b�RO�S�EzT�����f1�и�/=����;!j0��
�\F>O������Y6y������^n�˕S�U������­���#���
{P<Zp1H��O���2X߱Ķ(��%P��X���$-S��HZ�1o�g�������H���|U�l7��K���w��Q?X�vK��n����T-�L\�~�_{�
�,�~a��=����1?�Xt��]�/���f]��w�F-h14�B���M�C�|�UY+��8�����c$�.��c$�N}T��YB�A������A��������dSƀg5��2�xG3.�:X��#ӿ�r����w�@ߍ���C`ͫ+sFC�T��)�>J4��e    �������\�)O�6��#��uqg� �܆��B�߰��x�N=�En\��ٜ�t$t�,��3Kx����ފ��O�	���E��
���j��˞!��a���7��S�^ n���R�"��ѡ�W9������=�i��� {�A��O���B�����
�1]� U�d�xCBs�>B��qf�8K�Jq�u!�
u���T�]��;��ƽ	�b��v�;A�!����,Q���;���GP����#ߪE~��o�����f�l�J��3Ε�V��#N��rEkR�3��-�p��R��\˫�%Ǽn�л��/�(����E��Y�W?��1K�+L�.y<w��!pn7�
:��nfHw��$br��X����ܛ�!�C�9�����7F��|�x���e��5}�I�����r`�5��׈|U �zQ.՝b���6MPa�`��F�cjG"��=�6�rև��4[�6��iL�@�v�S�Aƣ�a�JU�:�/���(�x���Vf���d�N��QuW��+|�r�M�9׻fS����:��)��B䣜�|T�1� �u4cRm7eU|���k&�`E��w�J��-�~�~n|��y�-W�%�*��>*/b�k4�H[a�58�b��D���^�11{<�7Z`5�NRum��U-�ħ�����*��P�9O�.��'�׵�)���%4�Q��R\���`�;��Ig�Ȱ:nw����x8"�O��y��F�XWG�ŗqYM�5��?�ʒ���v��,�J֗|gw�Y�8g<؂��:XG0��_�m�Ӷ����D����z6K�*E�t��9;�W��	���{^6��2ƠQ����[���/A�ɚ�6v�O��s3�F>�$=��c�m1��f���2��{WɃz��)�2�a��m��}Pp�� �]��ξI鏅~�W_��+FB�6�.
;�>�ȭ�!R�-�\q�C�E��%I�|��G�?hfG��z���U%���T�X�˚�4��m �y'!8���J���( T���j�a�Jrm$����޴�3�j��T-����7���@���hEB�^����m+i�9�������)6J����V-o�-hC����	!���4� �jE�6u�ߟ��^^���g1��7���w�ENgfP�{#�#�����N�f�6�ҝ}��^:�s*��+��f��e�b����w����]7;�)��O
���0yl�R_GH`�s7����<�1���v>�[�J-\��>�7������2ϑ`��+lvvH���,�Z:��S?�ϟ�V�B�Ge��W��64O��'� ��t#oϮo�X�v��T��wm���2e|}%h�;b�`��Yl�2�t(���*�����3�p����n��.�Ǿ��G�0��7����[�l�`��e��o+�Ss�������h8N�9��߮����v~�lno�����/g�2�'}��5�݆�m�х�='���'�x~a��v��u�����v^L�-Mo�^���I�I��UC��Ҷ�0r���Z�� �ScC�VR���s�^�n4�����i(�r'�t��� ��M}g�q;�ʰ�;ڠ��6��o�������|$���*%B����*�e亥/���a��{h�.���_i��rBp�BbfU�e+��P�`�ᶿ�Qڱܥ�ӝ�b�MH;騌�(��������Fl�����;���@y�g����)iyM����]3~�w�et�l�rk�(�CN�]-g��sI4�DAIԻlB�E��y���/?�6@R��[�x0��.� xH� �mB���|���K�84�V��)@�}�_�/�����s���-��㗺ZѨ��M""Е��r�����b̓������(�n��sca{�W:�������l�䶯m��L��SMC���K�s�e;���$��=fJ <�M�������P��f�}N{��<0r��U�8�.�z�Y&���������KK�:e/~�Ї��� �� 7E,��omg�Wg��3�:� �Vq��������YV��L�]eWF���K�.����D$�,'���W�D_W@zԓ���9_�&�]j���ĆEN��H|�#��]��f�T��=��I�
��C>�N9�,F}
K�A	�I��Wb�4��Yb73�E�A�E���m�����w��x�)�����z�o�,�h�l���M��n�y���1��e�y�^>�޿g��]ðC��IP\�����nk��W���z��F O��)��`�/�"��-�,��� {��1k��",�����Ґ-��D��e5P����z	��N)B�@toy�|��P��VT����C����݅�$��!gB�y|4�G��8
��`�{C��6��}=&�qP�z�7���g��_�6�5��&�^Vk�QN�
_!�����(���f�/���a�i4wz���U�K�)��AfQu}��>��td�NQ��ސ�����w�ov��E�_���rq�H�?�y��/a(h7�o+߫>����LG��fq�j�V��u���p�H�7�4j_�M����d�A�!��(�.v�W�Kw��z�E.F�V���C���Y;�����{  .�^/��q{�����:l��7;�s�8���]��P���.�qn�)�(�l\;{���U��V!ʂ�FRp�r"p0���<��
ڏ+ӵ������bo3��ptIb����Q�#Y~<��z@�d���7��hn7�E�1��#`� ��ڐ�f�R,��qb�����}Hx����/���ݮɸ |۞�J�� *\3�+�w�1�J� �S�j_�o:^�8��.�1yw��a���|��ާ<担���T���[ku!#��-Q���F�%o:��2Mи� �w��M��܉�i��->�Y^ ץ�Z��m�h�cB�~�R(�E(�F�E���xk�4t���bS$}5t�Z�m~�x�<��9�,Q�5	(u���qwm{!����F~�I�%��#�m���R���Wş����7[qh���"��5�,g�d�u1��,d
�rfg��-[W�>8{)q�cCCɓ�ż�ϝ bLg�Io�M&�8��x�o��~~���~��"���lY�}��5���8Z�MF;�r�_����[�2�"'2���yǦ�����F�����S�������B ��V�v�A����L���3^.�����
s��^,��j��z3�܎��M۸���=��5�|�e�~��e�a�EW$�����RZom�M��;=��ݟ�6z�-q��Y5�~��h����b�z�5Z�V�g7�Wg�XiH�S��m�'�LM�@	��.=k��C �R�K��{�_9�#/z��(��a*����O*��BZ����G�oG���Ь۩ʍ~�Ͱ���נT���'Y��vk�R�tS�(iǭ�?C��:�,��[�#nƟYL��Z~��ak_K���L�y��2XB�
��*�-at�K��oF=T����_ؔq��1�"N�k���&JG#�󸟯��!縸�Mv�x�^��ZvjX��fw0��,�_�t��{�9������XB�w���ේ�q���?Լ���e%ma[.Uu���"��3�"7Ҁ�Vk%x%�����o�;oW���:{L7u�,~�!�O�NT(����"=Ҕ�4�o�#����1鴷��/���w D�e�s���<��U��t3=�	���)E���٨�DA<E'O]���w��<+^Hy�����CK�,!?�%��G^١(:��V2چ8z���+�'Ue�+��U��Mw�.������}#����W�y�o"��/ޱ���u����d0P~<�W�}�ʢb�X����R�U�Y��j|��fv���A��C��p��x�?v����Yf1���_���<�T����Y��������aḼc~f�0�6y��	�IU�������3�@��f�)�����k��6�>�fM0��r#���K�ɘZ�B��N5T`������+��Q�    >�����O<U���wׅl��>��%�o��l��Ǖ
sD��v@���l��	SϷ �C������j��k����. >J�c@�bӮ�[YYL����va�~������X�S�?������iËk`y1]�F��n!vwP�t�#Y��
��G�c�	�N[�1{[���M=�|���{�T`ITj���@o#�����uY&
��rBy�u����z?.�?�oڌ��&=��z�Rs�[��e�p������i�z���=�)P-�bT�y�A�
nuͿ���RP��<�?�h�w���D�"���3G�Pg@�������^ [.!�����t%,;�S���ݽ�d�?��!�J�/B����\�	x����������Dy@��YY�6�m���cЋ+Fǣ����aU��A>��6�wlJ���L���k����F;V~@[9U�����6��nYA4v]Өq�c�0��a�s�N��n����;��;7���k;}��W7� $`��ĶHv�N�N���w������� 	��%-F�*x���G��ǯ������W��1��FL�1�T���P���jq�+W|Y\"�&$kD�$�
]p�(� ��d�M5F��&��Z�#�E3ݎ�K� ��U��Fdy���;ga��f���[��nm8`Hp_�P4�u�B/J���^�?��T���� b���6��}O��4�T�<��;���m��J_;���$)�A5ϖ@����%I)`�,!�+Ӎ���|l�\j^e�R�Y+���:��W��(Wf@�ܚ�@�j���p��A(�C�� ��}��ޱi�^D������n�3:�Yʬ�����U��I�j|w�v����0T},@�U8�IZ_�|e�;�z���C��ϫ�w*�����gV�Q��y�8�9�v�Ӊ9k~g���F/%f��x�[���$�ӿIt�����k�.�iry�;���U�5À'�����a�R$���Nr��A���O��Ŧ��FS8]����벚=��z�Q�C^� ����삦�5�I�d�~j�v�n���uz����e���^���э�h�����TlmRCǗzq�qv��V@@E��
�y��ç"ȗ)c�{<^f�Mp�-c�[͐������q�\#-,��%����Hb�ĵy	���+8m#|-l�ؔ��&e�h�\�8�Db/Βވ��u����zƅu\y�ܽ)6�/��>#�������ÚQP�i�k�	��[�`���s����p�bFj����N�6��
~&<�Y�Q���R�L9ʘ��>��@h��������Y��V�=�rRj��加��v�om0N��&�K|���&ܭ�Q��}\(Gj�Z5p~�R��jѻ��+�{�����Z:"p:?^ ���/� _�RNZ�3�|u�d��Z#�K3�D�d�����숦�wK��f����lky]��L���F�."r[��Eb���m"�L����w�	�c��R�!��*l�+������ç�dڏAf�i���������� ����     