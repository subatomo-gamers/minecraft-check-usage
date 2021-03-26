#!/bin/bash
__DIR__=`dirname "${BASH_SOURCE}"`
source "${__DIR__}/config.ini"

CSV_MODE=""
while getopts c OPT; do
    case ${OPT} in
        c) CSV_MODE="1";;
    esac
done

worlds=`php "${__DIR__}/world-names.php"`
check=$?
if [ "${check}" != "0" ]; then
    exit 1
fi

for i in $worlds; do
    world_dir="${minecraft_dir}/${i}"
    if [ -d "${world_dir}" ]; then
        size=`du -s ${world_dir} | awk '{print $1}'`
    else
        size="0"
    fi

    if [ "${CSV_MODE}" ]; then
        echo ${i},${size}
    else
        fmtsize=`numfmt --to-unit=1024 ${size}`
        printf "%-20s%8d\n" ${i} ${fmtsize}
    fi
done
