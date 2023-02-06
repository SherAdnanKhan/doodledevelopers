#!/bin/bash
# Name: setup_pm2.sh
# Author: Jamie McDonald - 04/1/2020
# Desc: dirty script run by ansible to check we have node 12 installed, then install pm2 if required.

##
## First check we've not been run before.
##
if [ -e /opt/.installed_pm2 ]
	then
		#echo "PM2 installed"
		exit 0
fi


# now check we are running node12 or quit
node -v | grep 12 

if [ "$?" -ne "0" ]
	then
		echo "Could not find node12 installed"
		exit 1
fi

echo "Installing pm2 via npm"
npm i -g pm2 -f

touch /opt/.installed_pm2
