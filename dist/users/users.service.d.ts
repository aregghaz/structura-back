import { Repository } from 'typeorm';
import { User } from '../migration/user.entry';
export declare class UsersService {
    private usersRepository;
    constructor(usersRepository: Repository<User>);
    findAll(): Promise<User[]>;
    signIn(email: string): Promise<User | null>;
    findOne(id: number): Promise<User | null>;
    remove(id: number): Promise<void>;
    createUser(createUserDto: Record<string, any>): Promise<User>;
}
