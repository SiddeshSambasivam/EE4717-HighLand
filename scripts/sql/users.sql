USE HighLand;

INSERT INTO `users`(`email`, `phone`, `name`, `address`) VALUES ('test@gmail.com','+65 82568177','Bert','Nanyang Technological University, Singapore');

SET @last_id = LAST_INSERT_ID();

INSERT INTO `credentials`(`user_id`, `email`,`password`) VALUES (@last_id, 'test@gmail.com',md5('test'));