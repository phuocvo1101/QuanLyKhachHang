<div>

<form action="index.php?controller=user&action=login" method="post" align="center">
<table align="center" id="nen">
	<tr>	
		<td colspan="2" style="color:red;">
			{if isset($errorMessage)}
				{$errorMessage}
			{/if}
		</td>
	</tr>
	<tr>
		<td align="right">Username:</td>
		<td><input tyle="text" id='username' name='username' size="40"></td>
	</tr>
	<tr>
		<td align="right">Password:</td>
		<td><input type="password" id='password' name='password' size="25"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="submitLogin" value="Dang Nhap"><td>
	</tr>
</table>
</form>
</div>
