# Lib
import logging
import random
import unicodedata

import mysql.connector as mysql
from faker import Faker

# Const
HOST = "YOUR_HOST"
DATABASE = "YOUR_DATABASE"
USER = "YOUR_USER"
PASSWORD = "YOUR_PASSWORD"


# Instances
db_connection = mysql.connect(
    host=HOST, database=DATABASE, user=USER, password=PASSWORD
)
my_cursor = db_connection.cursor()
faker = Faker("fr_FR")
logging.basicConfig(level=logging.DEBUG)


# Functions
def getFakeData(nb: int) -> list[tuple]:
    """Allows to generate a user list containing a tuple for each user with his information.

    Args:
        nb (int): Desired number of user occurrences

    Returns:
        list[tuple]: List containing user tuples
    """
    list_of_data = []
    for _ in range(nb):
        # Define fake data
        first_name = faker.first_name()
        last_name = faker.last_name()
        username = f"{first_name.lower()}.{last_name.lower()}"
        username_without_specialchar = "".join(
            (
                c
                for c in unicodedata.normalize("NFD", username)
                if unicodedata.category(c) != "Mn"
            )
        )
        address = (
            f"{random.randint(0,9)}{random.randint(0,9)} {faker.street_name().title()}"
        )
        postal_code = faker.postcode()
        city = faker.city()
        email = f"{first_name.lower()}.{last_name.lower()}@{faker.domain_name()}"
        phone = f"06{random.randint(0,9)}{random.randint(0,9)}{random.randint(0,9)}{random.randint(0,9)}{random.randint(0,9)}{random.randint(0,9)}{random.randint(0,9)}{random.randint(0,9)}"
        password = faker.sha1()
        public_ip_address = faker.ipv4_public()
        is_subscribed = random.randint(0, 1)
        # Creating tuple
        tuple_user = (
            f"{username_without_specialchar}",
            f"{password}",
            f"{last_name}",
            f"{first_name}",
            f"{email}",
            phone,
            f"{address}",
            postal_code,
            f"{city}",
            f"{public_ip_address}",
            is_subscribed,
        )
        # Add to the list
        list_of_data.append(tuple_user)
    return list_of_data


def insertFakeUsers(nb: int) -> None:
    """Allows you to insert a list of user tuples into the database.
    Args:
        nb (int): Desired number of user occurrences
    """
    values = getFakeData(nb)
    query = "INSERT INTO utilisateur (loginUtilisateur, passUtilisateur, nomUtilisateur, prenomUtilisateur, emailUtilisateur, telUtilisateur, adresseRueUtilisateur, adresseCpUtilisateur, adresseVilleUtilisateur, adresseIpUtilisateur, isSubcribed) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    my_cursor.executemany(query, values)
    db_connection.commit()
    logging.info(f" {my_cursor.rowcount} lines was inserted.")


# Execution
if __name__ == "__main__":
    insertFakeUsers(3)
