using System;
using System.Text;
using System.Collections.Generic;
using System.Linq;
using Microsoft.VisualStudio.TestTools.UnitTesting;

public class Game
{
    private int itsScore = 0;
    private int[] itsThrows = new int[21];
    private int itsCurrentThrow = 0;

    public int GetScore()
    {
        return itsScore;
    }

    public void Add(int pins)
    {
        itsThrows[itsCurrentThrow++] = pins;
        itsScore += pins;
    }

    public int GetScoreForFrame(int theFrame)
    {
        int ball = 0;
        int score = 0;
        for (int currentFrame = 0;
        currentFrame < theFrame;
        currentFrame++)
        {
            int firstThrow = itsThrows[ball++];
            int secondThrow = itsThrows[ball++];
            int frameScore = firstThrow + secondThrow;
            if (frameScore == 10)
                score += frameScore + itsThrows[ball];
            else
                score += frameScore;
        }
        return score;
    }



}