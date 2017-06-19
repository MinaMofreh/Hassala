#!/bin/sh
IFS='#' read -r -a array <<< $(cat $1)
for element in "${array[@]}"
do
	echo "$element" | ./a.out >> outputfile.txt
done

