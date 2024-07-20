# Yatzy's Design System

A single-player game where 5 dice are rolled each turn. After each roll, the player chooses which dice to keep, and which to reroll. The player may reroll some or all of the dice up to two times on a turn. The player must put a score or zero into a score box each turn. The game ends when all score boxes are used.

## Appearance

### General

- Fonts: Arial, sans-serif
- Colors: Brown frame, dark green board, white dice with black dots, white table with green text (sometimes red text or golden text) and green lines, and blue buttons (can be grayed out)

### Dice

Five dice will appear on the dark green board when the player rolls the dice. Each dice will be shown in bird's eye view as rounded squares. The number of black dots on the die when viewed from above indicates the value of the roll. After rolling the dice, clicking on a die on the board turns it darker, which indicates which dice the player keeps. The dice that are not darknened in the board will be rerolled if the player chooses to do so.

### Leaderboard

The look and feel of the leaderboard is coded [here](assets/design_system/leaderboard.html). The font used is Segoe UI by default, but can fall back to the fonts mentioned in [General](#general). The leaderboard will be a brown tabular data with brown borders and translucent cells. It has 2 columns: Rank and Total Score.

## Game Components

### Starting a new game

The game starts immediately after this webpage is loaded. The player can restart the game by clicking the "Start Game" button. This resets the scoreboard and all the dice.

### In-game play

This game primarily uses no keyboard but rather clicks. To roll dice, click on the "Roll Dice" button. To select which dice to keep, click on them after rolling them. The "Roll Dice" button will allow for 2 more rerolls until it is grayed out and the player is forced to fill in the scoreboard, by clicking on a precalculated score (as indicated by a red number) in a table entry. After having put a score into a score box, the player can roll dice again and keep playing.

### Scoreboard

The scoreboard has 2 main sections: upper section (each box in which sums all dice showing its respective number) and lower section (one pair, two pairs, three of a kind, four of a kind, small straight, large straight, full house, chance, and yatzy). After having rolled the dice, the precalculated scores shown in red will appear in all unused boxes. Rerolling dice will update these scores accordingly. Clicking on a red score will complete a turn, and the score will turn green as it becomes fixed for the rest of the game.

### End of the game

After the player has filled in all of the score boxes, the game shows the total score as a separate row in the score table. The final score, along with the sum of the upper section and its bonus score, is shown in gold color, and the "Roll Dice" button is grayed out so that the player knows the game is over. The player can click the "Start Game" button to start a new game.