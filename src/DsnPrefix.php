<?php

namespace CommandString\Driver;

enum DsnPrefix: string
{
    case MYSQL = 'mysql';
    case POSTGRES = 'pgsql';
    case CUBRID = 'cubrid';
    case ORACLE = 'oci';
    case SQLITE = 'sqlite';
    case ODBC = 'odbc';
    case IBM = 'ibm';
    case MS_SQL = 'sqlsrv';
    case MS_SQL_LIB = 'sybase';
    case INFORMIX = 'informix';
    case FIREBIRD = 'firebird';
}
