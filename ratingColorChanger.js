function selected(new_state,num)
  {
  var state = new_state;
  if (state == 'up')
    {
    var color = '#006600';
    }
  else if (state == 'down')
    {
    var color = '#ff0000';
    }
  else if (state == 'unseen')
    {
    var color = '#c0c0c0';
    }
  document.getElementById('movie' + num).style.borderColor = color;
//		document.getElementById('movie' + num).style.borderColor = color;
//		var pid=this.parentNode.id;
//		this.parentNode.id = pid + new_state;
  }
