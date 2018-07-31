#!/bin/bash

cd ..
mv Q.I._IoT_Project_Web ~
cd
rm -rf web
mkdir web
mv Q.I._IoT_Project_Web web
cd web
mv Q.I._IoT_Project_Web public
cd public
mv public iot
