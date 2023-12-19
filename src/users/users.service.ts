import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { User } from '../migration/user.entry';
import * as bcrypt from 'bcrypt';

@Injectable()
export class UsersService {
  constructor(
    @InjectRepository(User)
    private usersRepository: Repository<User>,
  ) {}

  findAll(): Promise<User[]> {
    return this.usersRepository.find();
  }

  async signIn(email: string): Promise<User | null> {
    return this.usersRepository.findOneBy({
      email: email,
    });
  }

  findOne(id: number): Promise<User | null> {
    return this.usersRepository.findOneBy({ id });
  }

  async remove(id: number): Promise<void> {
    await this.usersRepository.delete(id);
  }

  /**
   * this is function is used to create User in User Entity.
   * @param createUserDto this will type of createUserDto in which
   * we have defined what are the keys we are expecting from body
   * @returns promise of user
   */
  async createUser(createUserDto: Record<string, any>): Promise<User> {
    const saltOrRounds = 10;
    const user: User = new User();
    user.name = createUserDto.name;
    user.surname = createUserDto.surname;
    user.fatherName = createUserDto.fatherName;
    user.country = createUserDto.country;
    user.dob = createUserDto.dob;
    user.email = createUserDto.email;
    user.passport = await bcrypt.hash(createUserDto.password, saltOrRounds);
    user.password = createUserDto.password;
    user.isActive = createUserDto.isActive;
    return this.usersRepository.save(user);
  }
}
