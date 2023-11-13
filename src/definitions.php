<?php

namespace PHPMaker2023\new2023;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Slim\HttpCache\CacheProvider;
use Slim\Flash\Messages;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => \DI\create(CacheProvider::class),
    "flash" => fn(ContainerInterface $c) => new Messages(),
    "view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "views/"),
    "audit" => fn(ContainerInterface $c) => (new Logger("audit"))->pushHandler(new AuditTrailHandler("audit.log")), // For audit trail
    "log" => fn(ContainerInterface $c) => (new Logger("log"))->pushHandler(new RotatingFileHandler($GLOBALS["RELATIVE_PATH"] . "log.log")),
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => fn(ContainerInterface $c) => new Guard($GLOBALS["ResponseFactory"], Config("CSRF_PREFIX")),
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "announcement" => \DI\create(Announcement::class),
    "breadcrumblinks" => \DI\create(Breadcrumblinks::class),
    "help" => \DI\create(Help::class),
    "help_categories" => \DI\create(HelpCategories::class),
    "languages" => \DI\create(Languages::class),
    "myuserprofile" => \DI\create(Myuserprofile::class),
    "settings" => \DI\create(Settings::class),
    "stats_counter" => \DI\create(StatsCounter::class),
    "stats_counterlog" => \DI\create(StatsCounterlog::class),
    "stats_date" => \DI\create(StatsDate::class),
    "stats_hour" => \DI\create(StatsHour::class),
    "stats_month" => \DI\create(StatsMonth::class),
    "stats_year" => \DI\create(StatsYear::class),
    "timezone" => \DI\create(Timezone::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "users" => \DI\create(Users::class),
    "dosen" => \DI\create(Dosen::class),
    "jabatan_fungsional" => \DI\create(JabatanFungsional::class),
    "jenjang" => \DI\create(Jenjang::class),
    "kelompok_penelitian" => \DI\create(KelompokPenelitian::class),
    "kelompok_pengabdian" => \DI\create(KelompokPengabdian::class),
    "kepakaran" => \DI\create(Kepakaran::class),
    "laporan_penelitian" => \DI\create(LaporanPenelitian::class),
    "laporan_pengabdian" => \DI\create(LaporanPengabdian::class),
    "proposal_penelitian" => \DI\create(ProposalPenelitian::class),
    "proposal_penelitian_status" => \DI\create(ProposalPenelitianStatus::class),
    "proposal_pengabdian" => \DI\create(ProposalPengabdian::class),
    "proposal_pengabdian_status" => \DI\create(ProposalPengabdianStatus::class),
    "rumpun_ilmu" => \DI\create(RumpunIlmu::class),
    "warna_kaver" => \DI\create(WarnaKaver::class),
    "home" => \DI\create(Home::class),
    "news" => \DI\create(News::class),
    "validasi" => \DI\create(Validasi::class),
    "vproposal_penelitian" => \DI\create(VproposalPenelitian::class),
    "vproposal_pengabdian" => \DI\create(VproposalPengabdian::class),
    "vproposal_penelitian_terima" => \DI\create(VproposalPenelitianTerima::class),
    "vproposal_pengabdian_diterima" => \DI\create(VproposalPengabdianDiterima::class),

    // User table
    "usertable" => \DI\get("users"),
];
