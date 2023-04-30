<?php

interface MyInterface
{
    // Contains abstract functions // يحتوي على دوال مجرة
    public function firstFunction();

    // Can not contain non-abstract functions (No-Body {}) // الدوال المجردة لا يكون لها كود برمجي
    // public function test(){};

}

class MyClass
{
    //Contains non-abstract functions // يحتوي على دوال لها كود برمجي
    public function normalFunction(){

    }

    //can not contain abstract functions // لا يحتوي على دوال مجردة
    // public function abstractFunction();
}

abstract class MyAbstractClass
{
    //Contains functions body
    public function normalFunction(){}

    //Contains abstract functions
    public abstract function abstractFunction();
}



// class A {}

// class B extends A {}

//**************************/

// class A
// {
//     public function test(){}
// }

// class B extends A
// {
// }

//**************************/

// abstract class A
// {
//     public function test(){}
// }

// class B extends A
// {
// }

//**************************/

// abstract class A
// {
//     public function test()
//     {
//     }

//     public abstract function myAbstractFunction();
// }

// abstract class B extends A
// {

// }


// interface Test
// {
//     function t1();
// }
