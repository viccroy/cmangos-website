cmangos-website (c) by Viccroy

cmangos-website is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.

You should have received a copy of the license along with this work. If not, see http://creativecommons.org/licenses/by-nc-nd/4.0/.<br/><br/>

![preview](https://github.com/user-attachments/assets/d3ce5079-6f11-49e7-9c58-ede81c4f83c5)

PHP CONFIGURATION:
- short_open_tag = On

PHP EXTENSIONS:
 - curl
 - json
 - gd
 - gmp
 - mbstring
 - openssl
 - pdo_mysql
 - soap
 - sockets

STEPS TO CONFIGURE WEBSITE:
 - Import ``website.sql`` into ``DB_WEBSITE`` database specified in ``config.php`` file.
 - Modify ``config.php`` file to suit your needs.
 - Change ``Battleground.ScoreStatistics`` from ``0`` to ``1`` in your ``mangosd.conf`` file.

STEPS TO ENABLE ARMORY:
 - Execute ``python retrieve_files.py``
 - Execute ``python convert_images.py``
 - Import ``armory.sql`` into ``DB_WEBSITE`` database specified in ``config.php`` file.
 - Change ``REALMS_ARMORY_ENABLED`` from ``false`` to ``true`` in ``config.php`` file.
 - Change ``PlayerSave.Stats.MinLevel`` from ``0`` to ``1`` in your ``mangosd.conf`` file.
 - Change ``PlayerSave.Stats.SaveOnlyOnLogout`` from ``1`` to ``0`` in your ``mangosd.conf`` file.