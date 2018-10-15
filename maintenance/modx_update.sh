#!/bin/bash
clear
DATE=`date +%m-%d-%Y-%H%M%N`;

if [ "$1" = '' ] || ! [ -d $1 ]; then
    INSTALLPATH="./"
elif [ -d $1 ]; then
	echo 'asd'
	INSTALLPATH=$1
fi

LOGFILE=$INSTALLPATH/BACKUP/log.err;
MODXPATH="https://github.com/modxcms/revolution/archive/";
MODXNAME="2.x.zip"

# Backup query

echo "Do you want to backup files and sql before update? Y/N"
read DOBACKUP
while [[ "$DOBACKUP" != 'Y' && "$DOBACKUP" != 'N' && "$DOBACKUP" != 'y' && "$DOBACKUP" != 'n' ]]; do
	echo "Please enter Y or N"
	read DOBACKUP
done

# backup process

if [ "$DOBACKUP" == 'Y' ] || [ "$DOBACKUP" == 'y' ]; then

	if [ ! -d $INSTALLPATH/BACKUP/ ]; then
		mkdir $INSTALLPATH/BACKUP/
	fi

	echo "Making files backup.."

	tar -pczf $INSTALLPATH/BACKUP/$DATE.tar.gz $INSTALLPATH* --exclude 'BACKUP/*' --exclude 'BACKUP' . 2>$LOGFILE
		if [ "$?" -eq 0 ]; then
		echo -e "Files backup success\n"
	else
		echo -e "Files backup error. Log file - $LOGFILE\n"
	fi

	echo -e "Making mysql backup..\n"

	echo "Please enter database NAME":
	read -s DBNAME
	echo "Please enter database USER":
	read -s DBUSER
	echo "Please enter database PASSWORD":
	read -s DBPASS


	mysqldump --opt -u $DBUSER -p$DBPASS $DBNAME > $INSTALLPATH/BACKUP/$DATE.sql 2>$LOGFILE
	if [ "$?" -eq 0 ]; then
		echo -e "\nDatabase backup success"
	else
		echo -e"\nDatabase backup error. Log file - $LOGFILE"
	fi

fi

# MODX install/update query

echo "Do you want to install/update MODX? Y/N"
read DOUPDATE
while [[ "$DOUPDATE" != 'Y' && "$DOUPDATE" != 'N' && "$DOUPDATE" != 'y' && "$DOUPDATE" != 'n' ]]; do
	echo "Please enter Y or N"
	read DOUPDATE
done

# install/update process

if [ "$DOUPDATE" == 'Y' ] || [ "$DOUPDATE" == 'y' ]; then

	echo -e "\nDownloading latest MODX release..."
	wget -P $INSTALLPATH $MODXPATH$MODXNAME 1>$LOGFILE 2>$LOGFILE;
	if [ "$?" -eq 0 ]; then
		echo -e "Download success\n"
	else
		echo -e "Download error. Log file - $LOGFILE"
		exit 1
	fi

	echo -e "\nCopying files..."
	unzip -qq $MODXNAME -d $INSTALLPATH;
	rm $INSTALLPATH$MODXNAME;

	cp -r $INSTALLPATH"revolution-master"/* $INSTALLPATH 1>$LOGFILE;
	if [ "$?" -eq 0 ]; then
		echo -e "Files copied successfuly\n"
	else
		echo -e "Files copy error. Log file - $LOGFILE\n"
		exit 1
	fi

	echo -e "Running build script...\n"
	rm -R $INSTALLPATH"revolution-master" 1>$LOGFILE;
	rm -Rf $INSTALLPATH"core/cache"/*

	mv $INSTALLPATH"_build/build.config.sample.php" $INSTALLPATH"_build/build.config.php";
	mv $INSTALLPATH"_build/build.properties.sample.php" $INSTALLPATH"_build/build.properties.php";

	php $INSTALLPATH"_build/transport.core.php";
	rm -R $INSTALLPATH"_build";

	echo -e "\nAll done, to continue the installation process go to http://youredomain/setup/"
	read QUIT
fi