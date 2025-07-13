-- Garante que a tabela seja removida se já existir para evitar erros de criação
DROP TABLE IF EXISTS `epic_boss_status`;

-- Cria a tabela epic_boss_status
CREATE TABLE `epic_boss_status` (
    `boss_id` INT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'alive', -- 'alive' ou 'dead'
    `respawn_time` BIGINT NOT NULL DEFAULT 0, -- Timestamp Unix do próximo respawn
    PRIMARY KEY (`boss_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- Inserção dos IDs e nomes dos chefes épicos e de instâncias comuns do Lineage II Interlude.
-- Os IDs são exemplos e podem variar ligeiramente dependendo da sua base de dados L2J.
-- Verifique os IDs reais dos NPCs na sua tabela 'npc' ou 'npcdata' se tiver dúvidas.
INSERT INTO `epic_boss_status` (`boss_id`, `name`, `status`, `respawn_time`) VALUES
(29001, 'Queen Ant', 'alive', 0),        -- Rainha Ant
(29006, 'Core', 'alive', 0),             -- Core
(29014, 'Orfen', 'alive', 0),            -- Orfen (mantido, pois é um epic boss clássico)
(29022, 'Zaken', 'alive', 0),            -- Zaken (Boss de instância, comum em Interlude custom)
(29019, 'Antharas', 'alive', 0),         -- Antharas (Dragon of Earth)
(29020, 'Baium', 'alive', 0),            -- Baium (Demon of Light)
(29047, 'Scarlet van Halisha', 'alive', 0), -- Scarlet van Halisha (Four Sepulchers)
(29028, 'Valakas', 'alive', 0),        -- Valakas (Introduzido em C6/Interlude Plus)
(29065, 'Sailren', 'alive', 0);           -- Lilith (Four Sepulchers)
