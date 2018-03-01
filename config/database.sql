CREATE TABLE `&points` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `time_limit` int(11) NOT NULL,
  `skip_cost` int(11) NOT NULL,
  `hints` int(11) NOT NULL,
  `hint_cost` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
----
CREATE TABLE `&quests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
----
CREATE TABLE `&teams` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `finished` int(1) NOT NULL DEFAULT '0',
  `quest_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
----
CREATE TABLE `&team_points` (
  `id` int(11) NOT NULL,
  `arrived` datetime DEFAULT NULL,
  `departed` datetime DEFAULT NULL,
  `hints_used` int(11) NOT NULL DEFAULT '0',
  `team_id` int(11) NOT NULL,
  `point_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
----
CREATE TABLE `&users` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
----
ALTER TABLE `&points` ADD PRIMARY KEY (`id`);
----
ALTER TABLE `&quests` ADD PRIMARY KEY (`id`);
----
ALTER TABLE `&teams` ADD PRIMARY KEY (`id`);
----
ALTER TABLE `&team_points` ADD PRIMARY KEY (`id`);
----
ALTER TABLE `&users` ADD PRIMARY KEY (`id`);
----
ALTER TABLE `&points` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
----
ALTER TABLE `&quests` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
----
ALTER TABLE `&teams` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
----
ALTER TABLE `&team_points` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
----
ALTER TABLE `&users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;