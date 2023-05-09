<?php
include dirname(__DIR__) . "/functions/db.php";

getConnection()->query("create table categories
(
    id   serial
        constraint categories_pk
            primary key,
    name varchar(255) not null
);");

getConnection()->query("create table posts
(
    id          serial
        constraint posts_pk
            primary key,
    title       varchar(255) not null,
    text        text         not null,
    image varchar(255) default null,
    category_id integer      not null
        constraint posts_categories_null_fk
            references categories (id)
            on update cascade on delete cascade
);");

getConnection()->query("create table users
(
	id serial
		constraint users_pk
			primary key,
	login varchar(255) not null,
	pass varchar(255) not null
);

create unique index users_login_uindex
	on users (login);

");

getConnection()->query("INSERT INTO public.categories (name) VALUES ('Хлеб')");

getConnection()->query("INSERT INTO public.categories (name) VALUES ('Мясо')");


getConnection()->query("INSERT INTO public.posts (title, text, category_id) VALUES ('Зачем на хлебе делают надрезы', 'Все, кто хоть раз имел дело с нарезным батоном, или с французским багетом, или с каким-нибудь другим пшеничным хлебом, помнят, что его украшают красивые шрамы-надрезы — продольные или наискосок, а иногда и красивые фигурные. Корочка у хлеба в этих местах светлее и лучше хрустит. Для появления этих разрезов есть веская причина — красота. Но речь не о том, кто красивее разрисует поверхность хлеба, а о том, чтобы он сохранил целостность в процессе выпекания и процессы, происходящие внутри него, можно было контролировать. Тогда хлеб останется красивым и не потеряет свой товарный вид.', 1)");


getConnection()->query("INSERT INTO public.posts (title, text, category_id) VALUES ('Хлеб в духовке', 'Домашний хлеб — большая радость и большая суета. Существуюn сотни способов его приготовить, и все они потребуют времени — хлебу нужно дать созреть, и с этим ничего не поделаешь. Мы решили приготовить наипростейший хлеб: минимальное количество доступных ингредиентов, никаких заквасок и максимум два часа на расстойку. Для этого мы позвали на нашу редакционную кухню молодого и веселого пекаря Ивана Шевченко, шеф-пекаря московских ресторанов Buro TSUM и Grace Bistro.', 1)");


getConnection()->query("INSERT INTO public.posts (title, text, category_id) VALUES ('Как приготовить идеальный стейк на сковороде', 'Приготовление стейка — не самодеятельность. Для того чтобы стейк раскрыл весь заложенный в нем потенциал, требуется почти математический расчет. Казалось бы, так даже проще, надо только найти точный рецепт. Но тут и начинается самое интересное: стоит залезть в интернет, как оттуда сыпется масса подробностей. В одних только методах членения мясной туши легко потеряться: чем вообще отличаются стриплойн и сирлойна, а рибай от пеканьи (кстати, об этом можно подробно почитать в этом материале) и как с ними правильно обращаться? Выстроить из часто противоречивой информации стройную систему действий мало у кого получается.', 2)");

getConnection()->query("INSERT INTO public.posts (title, text, category_id) VALUES ( 'Мясной рулет в духовом шкафу', 'Перед вами несложный рецепт мясного рулета со шпинатом и болгарским перцем, и еще более простым его делает наш новый духовой шкаф. Умная техника сама запечатает поверхность рулета и пропечет его так, чтобы он получился очень сочным и нежным, а вам не пришлось задавать вопросы, почему что-то вышло не так, как хотелось.', 2)");


