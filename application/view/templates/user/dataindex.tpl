{foreach $users as $item}
    <tr>

        <td><input type="checkbox" value="{$item->id}" /></td>
        <td>{$item->username}</td>
        <td>{$item->password}</td>
        <td>{$item->fullname}</td>
        <td>{$item->email}</td>
        <td>{$item->id}</td>


    </tr>
{/foreach}