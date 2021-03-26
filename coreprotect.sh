#!/bin/bash
__DIR__=`dirname "${BASH_SOURCE}"`
source "${__DIR__}/config.ini"
wc -c "${minecraft_dir}/plugins/CoreProtect/database.db" | awk '{print $1}'
