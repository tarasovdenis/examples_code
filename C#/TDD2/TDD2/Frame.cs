using System;
using System.Text;
using System.Collections.Generic;
using System.Linq;
using Microsoft.VisualStudio.TestTools.UnitTesting;

public class Frame
{
    private int itsScore = 0;
    public int Score
    {
        get { return itsScore; }
    }

    public void Add(int pins)
    {
        itsScore += pins;
    }
}