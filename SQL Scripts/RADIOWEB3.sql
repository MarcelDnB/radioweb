create table favorites(
username varchar2(20) references users,
song varchar2(100)
);
drop table favorites;