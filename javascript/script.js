var members = [
{
	firstname :"Santiago",
	secondname :"Martinez",
	email:"santiago.rueda-martinez@stud.hs-hannover.de",
},
{
        firstname :"Marius",
	secondname :"Darie",
	email:"marius-darie@stud.hs-hannover.de",
}

];





for (i = 0; i < members.length; i++) {
	document.write('<h4>'+members[i].firstname+' ');
	document.write(members[i].secondname+' ');
	document.write(members[i].email+'</h4>');
}






