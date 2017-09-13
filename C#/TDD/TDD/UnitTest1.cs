using System;
using System.Text;
using System.Collections.Generic;
using System.Linq;
using Microsoft.VisualStudio.TestTools.UnitTesting;

namespace TDD
{

    [TestClass]
    public class MathUtils
    {
        public static int Fibonacci(int n)
        {
            if (n == 0)
                return 0;
            else if (n == 1)
                return 1;
            else return Fibonacci(n - 1) + Fibonacci(n - 2);
        }

        [TestMethod]
        public void TestFirstFibonacciNumber()
        {
            Assert.AreEqual(0, MathUtils.Fibonacci(0));
        }

        [TestMethod]
        public void TestSecondFibonacciNumber()
        {
            Assert.AreEqual(1, MathUtils.Fibonacci(1));
        }

        [TestMethod]
        public void TestThirdFibonacciNumber()
        {
            Assert.AreEqual(1, MathUtils.Fibonacci(2));
        }

        [TestMethod]
        public void TestFourthFibonacciNumber()
        {
            Assert.AreEqual(2, MathUtils.Fibonacci(3));
        }
    }
}
