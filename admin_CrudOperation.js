let rowcount = 0;
        // Add new row to the table
        document.querySelector("#submit").addEventListener("click", (e) => {
            e.preventDefault();
            let name = document.getElementById('name').value;
            let product_price = document.getElementById('product_price').value;

            if (name == "" || product_price == "") {
                alert("All fields are required");
            } else {
                rowcount++;
                const tbody = document.querySelector('tbody');
                let tr = document.createElement('tr');
                let td1 = document.createElement('td');
                let td2 = document.createElement('td');
                let td3 = document.createElement('td');
                let td4 = document.createElement('td');

                td1.innerText = rowcount;
                td2.innerText = name;
                td3.innerText = product_price;
                td4.innerHTML = `
                    <button class="edit">Edit</button> 
                    <button class="save">Save</button> 
                    <button class="delete">Delete</button>`;

                // Append all td to row
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tbody.append(tr);

                // Action buttons functions
                let editbtn = document.querySelectorAll(".edit");
                let savebtn = document.querySelectorAll(".save");
                let deletebtn = document.querySelectorAll(".delete");

                for (let k = 0; k < editbtn.length; k++) {
                    // EDIT BUTTON
                    editbtn[k].onclick = function () {
                        let parent = this.parentElement.parentElement;
                        parent.style.border = "2px solid black";
                        parent.contentEditable = true;
                    };

                    // SAVE BUTTON
                    savebtn[k].onclick = function () {
                        let parent = this.parentElement.parentElement;
                        parent.style.border = "";
                        parent.contentEditable = false;
                    };

                    // DELETE BUTTON
                    deletebtn[k].onclick = function () {
                        let parent = this.parentElement.parentElement;
                        parent.remove();
                    };
                }
            }
        });