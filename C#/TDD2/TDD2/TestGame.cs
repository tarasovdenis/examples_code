using System;
using System.Text;
using System.Collections.Generic;
using System.Linq;
using Microsoft.VisualStudio.TestTools.UnitTesting;

namespace TDD2
{
    [TestFixture]
    public class TestGame
    {
        [Test]
        public void TestOneThrow()
        {
            Game g = new Game();
            g.Add(5);
            Assert.AreEqual(5, g.GetScore());
        }

        [Test]
        public void TestTwoThrowsNoMark()
        {
            Game g = new Game();
            g.Add(5);
            g.Add(4);
            Assert.AreEqual(9, g.GetScore());
        }

        [Test]
        public void TestFourThrowsNoMark()
        {
            Game g = new Game();
            g.Add(5);
            g.Add(4);
            g.Add(7);
            g.Add(2);
            Assert.AreEqual(18, g.GetScore());
            Assert.AreEqual(9, g.GetScoreForFrame(1));
            Assert.AreEqual(18, g.GetScoreForFrame(2));
        }

        [Test]
        public void TestSimpleSpare()
        {
            g.Add(3);
            g.Add(7);
            g.Add(3);
            Assert.AreEqual(13, g.GetScoreForFrame(1));
        }

        [Test]
        public void TestSimpleFrameAfterSpare()
        {
            g.Add(3);
            g.Add(7);
            g.Add(3);
            g.Add(2);
            Assert.AreEqual(13, g.GetScoreForFrame(1));
            Assert.AreEqual(18, g.GetScore());
        }

        [Test]
        public void TestSimpleFrameAfterSpare()
        {
            g.Add(3);
            g.Add(7);
            g.Add(3);
            g.Add(2);
            Assert.AreEqual(13, g.GetScoreForFrame(1)); Assert.AreEqual(18, g.GetScoreForFrame(2));
            Assert.AreEqual(18, g.GetScore());
        }

    }
}
