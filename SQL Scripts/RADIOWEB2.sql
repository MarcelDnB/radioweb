create or replace procedure registrar_usuario(w_username IN users.username%type, w_email IN users.email%type, w_password IN users.password%type, w_class IN users.class%type)
IS
BEGIN
INSERT INTO users(username,email, password,class)
VALUES (w_username, w_email, w_password, w_class);
COMMIT WORK;
end registrar_usuario;