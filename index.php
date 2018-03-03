<!DOCTYPE html>
<html>
    <head>
        <title>Tarea 3 - Manejo de Archivos</title>
    </head>
    <body>
        <header></header>
        <main id="container">
        <section id="all-contacts">
            <h3>All Contacts</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Omar Segura</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Carlos Arguedas</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Fabian Hernandez</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section id="add-contact">
            <form id="save-contact" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="work">Work:</label>
            <input type="text" id="work" name="work">
            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email">
            <label for="address">Address:</label>
            <textarea form="save-contact" id="address" name="address"></textarea>
            <button type="submit">Save</button>
            </form>
        </section>
        </main>
        <footer></footer>
    </body>
</html>