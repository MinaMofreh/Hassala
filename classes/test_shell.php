<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$code = '#include <iostream>
//using namespace std;
//int main(){
//int x;
//int y;
//cin >> x;
//cin >> y;
//if (x){
//cout << "Hello World" << endl;
//cout << y << endl;}
//else 
//cout << "ya3am zero ya3am";
//return 0;
//}';
//$myfile = fopen("code.cpp", "w+") or die("Unable to open file");
//fwrite($myfile, $code);
//fclose($myfile);
//$compile_output = shell_exec('g++ code.cpp');
//if ($compile_output == null){
//shell_exec('sh bashfile.sh');
//$output = shell_exec('diff -iwBbZ outputfile rightanswer');
//if ($output == null){
//    echo "True Answer";
//}
//}

$output = shell_exec("mkdir student_problem/$studentID");
$code = '#include <iostream>
using namespace std;
int main(){
cout << "Hello";
return 0;
}';
$myfile = fopen("student_problem/$studentID/code.cpp", "w+") or die("Unable to open file");
fwrite($myfile, $code);
fclose($myfile);
$compile_output = shell_exec("g++ /var/www/html/classes/student_problem/$studentID/code.cpp -o student_problem/$studentID/a.out");
if ($compile_output == NULL) {
    $running_output = shell_exec("LD_PRELOAD=/var/www/html/classes/EasySandbox-master/EasySandbox.so /var/www/html/classes/student_problem/$studentID/a.out");
}
