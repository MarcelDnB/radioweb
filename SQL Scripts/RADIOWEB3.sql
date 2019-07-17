create table favorites(
songname varchar2(300) references songs,
username varchar2(20) references users
);
drop table favorites;