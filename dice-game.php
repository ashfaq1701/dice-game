<?php

class DiceGame
{
    public function createDicePool($num)
    {
	$pool = [];
	for($i = 0; $i < $num; $i++)
	{
	    $pool[] = 2;
	}
	return $pool;
    }

    public function createPoolArray($num)
    {
	$pools = [];
        for($i = 0; $i < $num; $i++)
	{
	    $pools[] = $this->createDicePool(6);
	}
        return $pools;
    }
    
    public function rollPool($pool)
    {
	for($i = 0; $i < count($pool); $i++)
        {
	    $pool[$i] = rand(1, 6);
        }
        return $pool;
    }
    
    public function rollAllPools($pools)
    {
	for($i = 0; $i < count($pools); $i++)
	{
	    $pool = $pools[$i];
	    $pool = $this->rollPool($pool);
	    $pools[$i] = $pool;
	}
	return $pools;
    }

    public function movePools($pools)
    {
	$appendedElements = [];
	for($i = 0; $i < count($pools); $i++)	
	{
	    array_push($appendedElements, array());
	}
        for($i = 0; $i < count($pools); $i++)
        {
	    $nextPool = $i < (count($pools) - 1) ? $i+1 : 0;
	    foreach($pools[$i] as $item)
	    {
		if($item == 6)
		{
		    unset($pools[$i][array_search(6, $pools[$i])]);
		    $pools[$i] = array_values($pools[$i]);
		    continue;
		}
		if($item == 1)
		{
		    unset($pools[$i][array_search(1, $pools[$i])]);
		    $pools[$i] = array_values($pools[$i]);
		    array_push($appendedElements[$nextPool], 1);
		}
	    }
        }
	for($i = 0; $i < count($pools); $i++)
	{
	    $pools[$i] = array_merge($pools[$i], $appendedElements[$i]);
	}
	return $pools;
    }

    public function printPools($pools)
    {
        for($i = 0; $i < count($pools); $i++)
	{
	    $pool = $pools[$i];
	    echo 'Player '.($i+1).' : ';
	    for($j = 0; $j < count($pool); $j++)
	    {
		echo $pool[$j].' ';
	    }
	    echo "\n";
	}
    }

    public function game()
    {
	$poolArray = $this->createPoolArray(4);
	while(1)
	{
	    echo "\n\nAfter dice rolled: \n\n";
	    $poolArray = $this->rollAllPools($poolArray);
	    $this->printPools($poolArray);
	    echo "\n\nAfter dice moved\\removed:\n\n";
	    $poolArray = $this->movePools($poolArray);
	    $this->printPools($poolArray);
	    for($i = 0; $i < count($poolArray); $i++)
	    {
		$pool = $poolArray[$i];
		if(count($pool) == 0)
		{
		    echo "\n\n*********************************\n";
		    echo "Winner is Player ".($i+1);
		    echo "\n*********************************\n";    
		    break 2;
		}
	    }
	}
    }
}

$dice = new DiceGame();
$dice->game();
?>
