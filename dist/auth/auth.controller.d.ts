import { AuthService } from './auth.service';
import { UsersService } from '../users/users.service';
export declare class AuthController {
    private authService;
    private userService;
    constructor(authService: AuthService, userService: UsersService);
    createUser(ReqBody: Record<string, any>): Promise<import("../migration/user.entry").User>;
    findOne(signInDto: Record<string, any>): Promise<{
        access_token: string;
    }>;
    getProfile(req: any): any;
}
