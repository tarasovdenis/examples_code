using System;
using System.Text;
using System.Collections.Generic;
using System.Linq;
using Microsoft.VisualStudio.TestTools.UnitTesting;

namespace TDD2
{
    [TestClass]
    public class TestFrame
    {
        [TestMethod]
        public void TestScoreNoThrows()
        {
            Frame frame = new Frame();
            Assert.AreEqual(0, frame.Score);
        }

        [TestMethod]
        public void TestAddOneThrow()
        {
            Frame frame = new Frame();
            frame.Add(5);
            Assert.AreEqual(5, frame.Score);
        }
    }
}
