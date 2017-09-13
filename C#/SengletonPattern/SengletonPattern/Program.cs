using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace SengletonPattern
{
    class Program
    {
        static void Main(string[] args)
        {
            Singleton singleObject = Singleton.GetInstance();
            singleObject.flag = true;
            Console.WriteLine("singleObject = " + singleObject.flag);

            Singleton singleObject1 = Singleton.GetInstance();
            singleObject1.flag = false;

            Console.WriteLine("singleObject = " + singleObject.flag);
            Console.ReadLine();
        }

        sealed class Singleton 
        {
            private Singleton() { }

            private static Singleton single = new Singleton();

            public static Singleton GetInstance()
            {
                return single;
            }

            public bool flag;
        }


    }
}
